<?php namespace App\Modules\Report\Disposition\Repositories;
/**
 * Class ReportDispositionRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Report\Disposition\Interfaces\ReportDispositionInterface;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;

class ReportDispositionRepositories extends BaseRepository implements ReportDispositionInterface
{	
	const STR_RANDOM = 8;
	const CHUNK_SIZE = 100;
	
	public function model()
	{
		return DispositionModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->with([
			'employee',
			'assign'=> function($query) {
				$query->with(['employee', 'structure', 'class_disposition']);
			},
			'incoming' => function($query) {
				$query->with(['structure']);
			}
		])
		->whereHas('incoming', function ($q) use ($request) {
			if ($request->has('type_id') && !empty($request->type_id)) {
				$q->where('type_id', $request->type_id);
			}
			
			if ($request->has('classification_id') && !empty($request->classification_id)) {
				$q->where('classification_id', $request->classification_id);
			}
			
			if ($request->has('structure_id') && !empty($request->structure_id)) {
				$q->where('structure_id', $request->structure_id);
			}
			
		})->categoryReport();
		
		if ($request->has('start_date') &&  $request->has('end_date')) {
			if (!empty($request->start_date) && !empty($request->end_date)) {
				$query->whereBetween('disposition_date', [$request->start_date, $request->end_date]);	
			}
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
			
			$pdf->Cell(0, 15, 'DISPOSISI SURAT', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
		PDF::SetTitle('REPORT DISPOSISI SURAT');
		PDF::SetSubject('REPORT');
		
		PDF::SetAutoPageBreak(TRUE, 10);
		
		PDF::SetMargins(10, 40, 10);
			
		PDF::SetFont('helvetica', '', 6);
		
		PDF::AddPage('L', 'A4');
		$i = 0;
		$html = '<table cellspacing="1" bgcolor="#666666" cellpadding="2">
				<tr bgcolor="#f0f0f0">
					<th width="3%" align="center">No</th>
					<th width="21%" align="center">Nomor Surat Masuk</th>
					<th width="25%" align="center"><b><i>Nomor & Perihal Disposisi</i></b></th>
					<th width="5%" align="center">Tanggal Disposisi</th>
					<th width="10%" align="center">Organisasi</th>
					<th width="10%" align="center">Disposisi Oleh</th>
					<th width="21%" align="center">Description</th>
					<th width="5%" align="center">Status</th>
				</tr>';
		foreach($data->chunk(self::CHUNK_SIZE) as $chunks) {
			foreach ($chunks as $dt) 
			{
				$i++;
				$number = !empty($dt->incoming) ? '('. $dt->incoming->number_letter.') ' : '';
				$structure = !empty($dt->incoming->structure) ? $dt->incoming->structure->nama_struktur : 'N/A';
				$to = !empty($dt->employee) ? $dt->employee->name : 'N/A';
				$color = $dt->status == IncomingMailStatusConstans::DONE ? '#58b4ae' : '#ffb367';
				
				$html .='<tr bgcolor="#ffffff">
					<td align="center">'.$i.'</td>
					<td>'.$number. $dt->subject_letter.'</td>
					<td>'.$dt->number_disposition. ' ' .$dt->subject_disposition.'</td>
					<td align="center">'.Carbon::parse($dt->date_disposition)->format('d-m-Y').'</td>
					<td align="center">'.$structure.'</td>
					<td align="center">'.$to.'</td>
					<td align="center">'.$dt->description.'</td>
					<td align="center" bgcolor="'.$color.'">'.config('constans.action-status-disposition.'. $dt->status).'</td>
				</tr>';
				
				if (!$dt->assign->isEmpty()) {
					$html .='<tr bgcolor="#ffffff">
						<td colspan="8" align="left"><b><i>Disposisi Kepada :</i></b></td>
					</tr>';
					
					$html .= '<tr bgcolor="#ffffff">
					<td colspan="8"><table cellspacing="1" bgcolor="#666666" cellpadding="2">
					<tr bgcolor="#f0f0f0">
						<th width="3%" align="center">No</th>
						<th width="21%" align="center">Organisasi</th>
						<th width="25%" align="center">Pegawai</th>
						<th width="15%" align="center">Klasifikasi Disposisi</th>
						<th width="21%" align="center">Tindak Lanjut</th>
						<th width="15%" align="center">Status Tindak Lanjut</th>
					</tr>';
					
					$noa = 1;
					foreach ($dt->assign as $assign) {
						$structure_as = !empty($assign->structure) ? $assign->structure->nama_struktur : 'N/A';
						$employee_as = !empty($assign->employee) ? $assign->employee->name : 'N/A';
						$class = !empty($assign->class_disposition) ? $assign->class_disposition->name : 'N/A';
						$follow = !$assign->follow_ups->isEmpty() ? $assign->follow_ups[0]->description : '-';
						$follow_color = !$assign->follow_ups->isEmpty() ? '#58b4ae' : '#d9455f';
						$follow_status = !$assign->follow_ups->isEmpty() ? 'Done' : 'Not Action';
						$html .='<tr bgcolor="#ffffff">
						<td align="center">'.$noa++.'</td>
						<td align="center">'.$structure_as.'</td>
						<td align="center">'.$employee_as.'</td>
						<td align="center">'.$class.'</td>
						<td align="center">'.$follow.'</td>
						<td align="center" bgcolor="'.$follow_color.'">'.$follow_status.'</td>
					</tr>';
					}
					
					$html .='</table></td></tr>';
					
				}
			}
		}
		
		$html .='</table>';
		
		PDF::writeHTML($html, true, 0, true, 0);
		
		PDF::Output('REPORT_SURAT_DISPOSISI_'.Str::random(self::STR_RANDOM).'.pdf', 'I');
	}
}
