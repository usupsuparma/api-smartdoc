<?php namespace App\Modules\Report\Outgoing\Repositories;
/**
 * Class ReportOutgoingRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Report\Outgoing\Interfaces\ReportOutgoingInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;

class ReportOutgoingRepositories extends BaseRepository implements ReportOutgoingInterface
{	
	const STR_RANDOM = 8;
	
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->categoryReport();
		
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
		
		if ($request->has('status') && !empty($request->status)) {
			$query->where('status', $request->status);
		}

		if ($request->has('structure_id') && !empty($request->structure_id)) {
			$query->where('created_by_structure', $request->structure_id);
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
			$pdf->Ln(10); 
			
			$pdf->Cell(0, 15, 'LAPORAN', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(7);
			
			$pdf->SetFont('helvetica', 'B', 12);
			
			$pdf->Cell(0, 15, 'SURAT KELUAR', 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(7); 
			
			$pdf->SetFont('helvetica', 'B', 10);
			$pdf->SetTextColor(18, 107, 151);
			$pdf->Cell(0, 15, setting_by_code('COMPANY_NAME'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(7); 
			
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetTextColor(0);
			$pdf->Cell(0, 15, 'Periode : '.$periode , 0, false, 'L', 0, '', 0, false, 'M', 'M');
			$pdf->Cell(0, 15, 'Tanggal Cetak : '. Carbon::now()->translatedFormat('l, j F Y') , 0, false, 'R', 0, '', 0, false, 'M', 'M');
			
			$pdf->Ln(2); 
			 
			$pdf->Cell(0, 0, '', 'B', false, 'R', 0, '', 0, false, 'M', 'M');
			
		});

		/* Footer */
		PDF::setFooterCallback(function($pdf) {
			$footerSigned = 'Laporan ini resmi dikeluarkan oleh '. setting_by_code('COMPANY_NAME');
			$pdf->SetY(-15);
			$pdf->SetFont('helvetica', 'I', 6);
			$pdf->MultiCell(150, 5, $footerSigned, 0, 'L', 0, 0, '', '', true);
			$pdf->Cell(0, 2, 'Halaman Ke - '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages(), false, false, 'R', 0, '', 0, false, 'T', 'M');
		});
		
		PDF::SetCreator(PDF_CREATOR);
		PDF::SetAuthor('BIJB');
		PDF::SetTitle('REPORT SURAT KELUAR');
		PDF::SetSubject('REPORT');
		
		PDF::SetAutoPageBreak(TRUE, 10);
		
		PDF::SetMargins(10, 40, 10);
			
		PDF::SetFont('helvetica', '', 10);
		
		PDF::AddPage();
		
		PDF::writeHTML('', true, 0, true, 0);
		
		PDF::Output('REPORT_SURAT_KELUAR_'.Str::random(self::STR_RANDOM).'.pdf', 'I');
	}
}
