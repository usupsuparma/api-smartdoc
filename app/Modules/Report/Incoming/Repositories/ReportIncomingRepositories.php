<?php namespace App\Modules\Report\Incoming\Repositories;
/**
 * Class ReportIncomingRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Report\Incoming\Interfaces\ReportIncomingInterface;
use App\Modules\IncomingMail\Models\IncomingMailModel;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;

class ReportIncomingRepositories extends BaseRepository implements ReportIncomingInterface
{	
	const STR_RANDOM = 8;
	const CHUNK_SIZE = 100;
	
	public function model()
	{
		return IncomingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->with([
			'type',
			'classification',
			'to_employee',
			'structure',
		]);
		
		if ($request->has('type_id') && !empty($request->type_id)) {
			$query->where('type_id', $request->type_id);
		}
		
		if ($request->has('classification_id') && !empty($request->classification_id)) {
			$query->where('classification_id', $request->classification_id);
		}
		
		if ($request->has('start_date') &&  $request->has('end_date')) {
			if (!empty($request->start_date) && !empty($request->end_date)) {
				$query->whereBetween('letter_date', [$request->start_date, $request->end_date]);	
			}
		}

		if ($request->has('structure_id') && !empty($request->structure_id)) {
			$query->where('structure_id', $request->structure_id);
		}

		return $query->get();
	}
	
	public function export_data($request)
    {
		$data = $this->data($request);
		return $this->export($data, $request);
	
	}
	
	private function export($data, $request)
	{
		PDF::setHeaderCallback(function($pdf) use ($request)  {
			Carbon::setLocale('id');
			$start_date = Carbon::parse($request->start_date)->translatedFormat('j F Y');
			$end_date = Carbon::parse($request->end_date)->translatedFormat('j F Y');
			$periode = $start_date. ' - '.$end_date;
			
			$pdf->Ln(10); 

			$image_file = base_path('public/assets/img/').'logo.png';
			$pdf->Image($image_file, 5, 5, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			
			$pdf->SetFont('helvetica', 'B', 15);
			$pdf->SetAlpha(0.7);
			$pdf->SetTextColor(0);
			$pdf->Ln(5);
			
			$pdf->Cell(0, 15, 'LAPORAN', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5);
			
			$pdf->SetFont('helvetica', 'B', 12);
			
			$pdf->Cell(0, 15, 'SURAT MASUK', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->SetTextColor(18, 107, 151);
			$pdf->Cell(0, 15, setting_by_code('COMPANY_NAME'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(10); 
			
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetTextColor(0);
			$pdf->Cell(0, 15, 'Periode : '.$periode , 0, false, 'L', 0, '', 0, false, 'M', 'M');
			$pdf->Cell(0, 15, 'Tanggal Cetak : '. Carbon::now()->translatedFormat('l, j F Y') , 0, false, 'R', 0, '', 0, false, 'M', 'M');
			
			$pdf->Ln(2); 
			 
			$pdf->Cell(0, 0, '', 'B', false, 'R', 0, '', 0, false, 'M', 'M');
			
		});

		/* Footer */
		PDF::setFooterCallback(function($pdf) {
			$footerSigned = 'Laporan ini dikeluarkan oleh SmartDoc '. setting_by_code('COMPANY_NAME');
			$pdf->SetY(-15);
			$pdf->SetFont('helvetica', 'I', 6);
			$pdf->MultiCell(150, 5, $footerSigned, 0, 'L', 0, 0, '', '', true);
			$pdf->Cell(0, 2, 'Halaman Ke - '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages(), false, false, 'R', 0, '', 0, false, 'T', 'M');
		});
		
		PDF::SetCreator(PDF_CREATOR);
		PDF::SetAuthor('BIJB');
		PDF::SetTitle('REPORT SURAT MASUK');
		PDF::SetSubject('REPORT');
		
		PDF::SetAutoPageBreak(TRUE, 10);
		
		PDF::SetMargins(10, 40, 10);
			
		PDF::SetFont('helvetica', '', 6);
		
		PDF::AddPage('L', 'A4');
		$i = 0;
		$html = '<table cellspacing="1" bgcolor="#666666" cellpadding="2">
				<tr bgcolor="#f0f0f0">
					<th width="3%" align="center">No</th>
					<th width="30%" align="center">Nomor & Perihal Surat</th>
					<th width="10%" align="center">Tipe</th>
					<th width="10%" align="center">Klasifikasi</th>
					<th width="5%" align="center">Tanggal Surat</th>
					<th width="5%" align="center">Tanggal Diterima</th>
					<th width="8%" align="center">Pengirim</th>
					<th width="8%" align="center">Penerima</th>
					<th width="8%" align="center">Organisasi</th>
					<th width="8%" align="center">Untuk</th>
					<th width="5%" align="center">Disposisi</th>
				</tr>';
		foreach($data->chunk(self::CHUNK_SIZE) as $chunks) {
			foreach ($chunks as $dt) 
			{
				$i++;
				$number = !empty($dt->number_letter) ? '('. $dt->number_letter.') ' : '';
				$type = !empty($dt->type) ? $dt->type->name : 'N/A';
				$classification = !empty($dt->classification) ? $dt->classification->name : 'N/A';
				$sender_name = !empty($dt->sender_name) ? $dt->sender_name : 'N/A';
				$receiver_name = !empty($dt->receiver_name) ? $dt->receiver_name : 'N/A';
				$structure = !empty($dt->structure) ? $dt->structure->nama_struktur : 'N/A';
				$to = !empty($dt->to_employee) ? $dt->to_employee->name : 'N/A';
				$disposisi = !empty($dt->disposition) ? 'Ya' : 'Tidak';
				
				$html .='<tr bgcolor="#ffffff">
					<td align="center">'.$i.'</td>
					<td>'.$number. $dt->subject_letter.'</td>
					<td>'.$type.'</td>
					<td align="center">'.$classification.'</td>
					<td align="center">'.Carbon::parse($dt->letter_date)->format('d-m-Y').'</td>
					<td align="center">'.Carbon::parse($dt->recieved_date)->format('d-m-Y').'</td>
					<td align="center">'.$sender_name.'</td>
					<td align="center">'.$receiver_name.'</td>
					<td align="center">'.$structure.'</td>
					<td align="center">'.$to.'</td>
					<td align="center" >'.$disposisi.'</td>
				</tr>';
				
				if (!$dt->follow_ups->isEmpty()) {
					$html .='<tr bgcolor="#ffffff">
						<td colspan="2"align="left">Tindak Lanjut</td>
						<td colspan="9">'.$dt->follow_ups[0]->description.'</td>
					</tr>';
				}
			}
		}
		
		$html .='</table>';
		
		PDF::writeHTML($html, true, 0, true, 0);
		
		PDF::Output('REPORT_SURAT_MASUK_'.Str::random(self::STR_RANDOM).'.pdf', 'D');
	}
}
