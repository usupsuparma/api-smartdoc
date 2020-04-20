<?php namespace App\Library\Managers\Smartdoc;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use PDF;
use GlobalHelper;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class Smartdoc extends PDF
{
	protected $company_name;
	protected $company_address_1;
	protected $company_address_2;
	protected $company_address_3;
	protected $company_contact;
	
	public static function outgoing_mail($model, $data = [])
	{
		/* Header */
		PDF::setHeaderCallback(function($pdf) {
			
			$pdf->Ln(5); 
			
			$image_file = base_path('public/assets/img/').'logo.png';
			$pdf->Image($image_file, 0, 0, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$pdf->SetFont('helvetica', 'B', 8);
			$pdf->SetTextColor(18, 107, 151);
			$pdf->Ln(10); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_NAME'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetTextColor(0);
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_ADDRESS_1'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_ADDRESS_2'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_ADDRESS_3'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_CONTACT'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5);
			 
			$pdf->Cell(0, 0, '', 'B', false, 'R', 0, '', 0, false, 'M', 'M');
			
		});

		/* Footer */
		PDF::setFooterCallback(function($pdf) {
			$pdf->SetY(-15);
			$pdf->SetFont('helvetica', 'I', 6);
			$pdf->Cell(0, 5, 'Halaman Ke - '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
		});
		
		PDF::SetCreator(PDF_CREATOR);
		PDF::SetAuthor(!empty($model->created_by) ? $model->created_by->name : '');
		PDF::SetTitle('Surat Keluar');
		PDF::SetSubject($model->subject_letter);
		
		PDF::SetAutoPageBreak(TRUE, 20);
		
		PDF::SetProtection([
			'modify', 
			'copy', 
			'annot-forms', 
			'fill-forms', 
			'extract', 
			'assemble'
		], '', null, 0, null);
		
		PDF::SetMargins(10, 40, 10);
		
		PDF::SetFont('helvetica', '', 10);
		
		PDF::AddPage();
		
		$body = (new self)->parsing_body($model);
		
		PDF::writeHTML($body, true, 0, true, 0);

		/* QR Code */
		if (PDF::getPage() === PDF::getNumPages()) {
			if (isset($data['image_qr'])) {
				$image_file = storage_path('app/public'. $data['image_qr']);
				PDF::Image($image_file, 15, 240, 30, 30, 'PNG');
			}
		}
		
		/* File Name */
		$structure_code = !empty($model->structure_by) ? $model->structure_by->kode_struktur : '';
		$type_code = !empty($model->type) ? $model->type->code : '';
		$number_letter = !empty($model->number_letter) ? $model->number_letter. '-' : '';
		$filename = $number_letter. $type_code. '-'. $structure_code. '-'. time(). '.pdf';
		
		if (!empty($model->subject_letter)) {
			$filename = 'Surat_Keluar_'.sha1(time()). '.pdf';
		}
		
		$path = storage_path('app/public'. setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'));

		PDF::Output($path. $filename, 'F');
		
		return setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'). $filename;
	}
	
	public static function outgoing_mail_signature($model, $data = [])
	{
		/* Header */
		PDF::setHeaderCallback(function($pdf) {
			
			$pdf->Ln(5); 
			
			$image_file = base_path('public/assets/img/').'logo.png';
			$pdf->Image($image_file, 0, 0, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			$pdf->SetFont('helvetica', 'B', 8);
			$pdf->SetTextColor(18, 107, 151);
			$pdf->Ln(10); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_NAME'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetTextColor(0);
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_ADDRESS_1'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_ADDRESS_2'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_ADDRESS_3'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5); 
			
			$pdf->Cell(0, 15, setting_by_code('COMPANY_CONTACT'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$pdf->Ln(5);
			 
			$pdf->Cell(0, 0, '', 'B', false, 'R', 0, '', 0, false, 'M', 'M');
			
		});

		/* Footer */
		PDF::setFooterCallback(function($pdf) {
			$footerSigned = 'Sesuai dengan ketentuan yang berlaku, '. setting_by_code('COMPANY_NAME').' mengatur bahwa Surat ini telah ditandatangani secara elektronik. Sehingga tidak diperlukan tanda tangan basah pada Surat ini.';
			
			$pdf->SetY(-15);
			$pdf->SetFont('helvetica', 'I', 6);
			$pdf->MultiCell(150, 5, $footerSigned, 0, 'L', 0, 0, '', '', true);
			$pdf->Cell(0, 2, 'Halaman Ke - '.$pdf->getAliasNumPage().' / '.$pdf->getAliasNbPages(), false, false, 'R', 0, '', 0, false, 'T', 'M');
			
		});
		
		$public = 'file://'. storage_path('app/public'. $model->signature->path_public_key);
		$private = 'file://'. storage_path('app/public'. $model->signature->path_private_key);
		$address = setting_by_code('COMPANY_NAME'). ' '. setting_by_code('COMPANY_ADDRESS_1') .' '.setting_by_code('COMPANY_ADDRESS_1').' '.setting_by_code('COMPANY_ADDRESS_3');
		
		PDF::SetCreator(PDF_CREATOR);
		PDF::SetAuthor(!empty($model->created_by) ? $model->created_by->name : '');
		PDF::SetTitle('Surat Keluar');
		PDF::SetSubject($model->subject_letter);
		
		PDF::SetAutoPageBreak(TRUE, 20);
		
		PDF::SetProtection([
			'modify', 
			'copy', 
			'annot-forms', 
			'fill-forms', 
			'extract', 
			'assemble'
		], '', null, 0, null);
		
		$info = [
			'Name' => PDF_CREATOR,
			'Location' => $address,
			'Reason' => 'Surat Keluar',
			'ContactInfo' => '',
		];
		
		PDF::setSignature($public, $private, Crypt::decrypt($model->signature->credential_key), '' , 2, $info);
		
		PDF::SetMargins(10, 40, 10);
		
		PDF::SetFont('helvetica', '', 10);
		
		PDF::AddPage();
		
		$body = (new self)->parsing_body($model);
		
		PDF::writeHTML($body, true, 0, true, 0);

		/* QR Code */
		if (PDF::getPage() === PDF::getNumPages()) {
			if (isset($data['image_qr'])) {
				$image_file = storage_path('app/public'. $data['image_qr']);
				PDF::Image($image_file, 15, 240, 30, 30, 'PNG');
			}
		}
		
		/* File Name */
		$structure_code = !empty($model->structure_by) ? $model->structure_by->kode_struktur : '';
		$type_code = !empty($model->type) ? $model->type->code : '';
		$number_letter = !empty($model->number_letter) ? $model->number_letter. '-' : '';
		$filename = $number_letter. $type_code. '-'. $structure_code. '-'. time(). '.pdf';
		
		if (!empty($model->subject_letter)) {
			$filename = 'Surat_Keluar_'.sha1(time()). '.pdf';
		}
		
		$path = storage_path('app/public'. setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'));
		
		PDF::Output($path. $filename, 'F');
		
		return setting_by_code('PATH_DIGITAL_OUTGOING_MAIL'). $filename;
	}
	
	public function generate()
    {
		$public = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/test_public_key.pem';
		$private = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/test_private_key.pem';
		$filekosongan = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/ND - Nota Dinas.pdf';
		
		PDF::SetCreator(PDF_CREATOR);
		PDF::SetAuthor('Adam Lesamana Ganda Saputra');
		PDF::SetTitle('Surat Keluar');
		PDF::SetSubject('Subject');
		
		$address = setting_by_code('COMPANY_NAME'). ' '. setting_by_code('COMPANY_ADDRESS_1') .' '.setting_by_code('COMPANY_ADDRESS_1').' '.setting_by_code('COMPANY_ADDRESS_3');
		$info = array(
			'Name' => PDF_CREATOR,
			'Location' => $address,
			'Reason' => 'Surat Keluar',
			'ContactInfo' => '',
			);
			
		/* Signature */
		
		PDF::setSignature($public, $private, 'X8HCRIAD', '' , 2, $info);
		PDF::SetFont('helvetica', '', 12);
		PDF::AddPage();
		$text = 'This is a <b color="#FF0000">Clean and add digitally signed document</b> ADAM LESMANA GANDA SAPUTRA';
		PDF::writeHTML($text, true, 0, true, 0);
		// PDF::Image('images/tcpdf_signature.png', 180, 60, 15, 15, 'PNG');
		PDF::setSignatureAppearance(180, 60, 15, 15);
		PDF::addEmptySignatureAppearance(180, 80, 15, 15);
		
		/* Kosongan */
		
		// $pages = PDF::setSourceFile($filekosongan);
		
		// for ($i = 1; $i <= $pages; $i++)
    	// {
		// 	PDF::AddPage();
		// 	$page = PDF::importPage($i);
		// 	PDF::useTemplate($page, 0, 0);
		// 	PDF::setSignature($public, $private, 'X8HCRIAD', '' , 2, $info);
		// }
		
		PDF::Output('/Users/aelgees/PIDUITEUN/php/dgsign/TEST TAI.pdf', 'F');
	}
	
	public function render_code_outgoing($model)
	{
		$type_code = $model->type->code;
		$structure_code = $model->structure_by->kode_struktur;
		$format = '/'. $type_code. '-'. $structure_code. '/BIJB/';
		$str_number = '/'. $type_code. '-'. $structure_code. '/BIJB/'. date('m'). '/'. date('Y');
		
		$query = OutgoingMailModel::maxNumber($format);
		
		$max_number = (!empty($query) ? $query->max_number : '');
		$number = (int) substr($max_number, 0, 4);
		$number++;
		$number_letter = sprintf("%04s", $number). $str_number;
		
		return $number_letter;							
	}
	
	private function parsing_body($model)
	{
		Carbon::setLocale('id');
		$forwards = '';
		
		if (!empty($model->forwards)) {
			$forwards .= '<p>Tembusan Tyh: </p>';
			$forwards .= '<ol>';
			foreach ($model->forwards as $fw) {
				$forwards .= '<li>'. $fw->employee->name .'</li>';
			}
			$forwards .= '</ol>';
		}
		
		$origin = [
			'#SUBJECT#',
			'#NOMORSURAT#',
			'#TANGGALSURAT#',
			'#TEMBUSAN#'
		];
		
        $replace   = [
			$model->subject_letter, 
			$model->number_letter,
			Carbon::parse($model->letter_date)->translatedFormat('l j F Y'),
			$forwards
		];
        
		return str_replace($origin, $replace, $model->body);
	}

}