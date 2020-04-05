<?php namespace App\Library\Managers\Smartdoc;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use PDF;
use GlobalHelper;
use QRcode;
class Smartdoc extends PDF
{
	protected $company_name;
	protected $company_address_1;
	protected $company_address_2;
	protected $company_address_3;
	protected $company_contact;
	
	public static function outgoing_mail($data)
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
		PDF::SetAuthor('Nicola Asuni');
		PDF::SetTitle('TCPDF Example 003');
		PDF::SetSubject('TCPDF Tutorial');
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
		
		$text = '<h2 style="text-align: center;">What is Lorem Ipsum?</h2>
		<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<h2>What is Lorem Ipsum?</h2>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
		<p style="text-align: justify;"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';
		

		PDF::writeHTML($text, true, 0, true, 0);

		/* QR Code */
		if (PDF::getPage() === PDF::getNumPages()) {
			$image_file = storage_path('app/public'. $data['image_qr']);
			PDF::Image($image_file, 15, 240, 30, 30, 'PNG');
		}
		
		/* File Name */
		$file_name = 
		
		PDF::Output('BABA.pdf', 'I');
	}
	
	public function generate()
    {
		$public = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/public_key.pem';
		$private = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/private_key.pem';
		$filekosongan = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/ND - Nota Dinas.pdf';
		
		
		$info = array(
			'Name' => 'ADAM LESMANA',
			'Location' => 'TEST',
			'Reason' => 'TEST',
			'ContactInfo' => 'aelgees.dev@gmail.com',
			);
			
		/* Signature */
		
		// PDF::setSignature($public, $private, 'X8HCRIAD', '' , 2, $info);
		// PDF::SetFont('helvetica', '', 12);
		// PDF::AddPage();
		// $text = 'This is a <b color="#FF0000">Clean and add digitally signed document</b> ADAM LESMANA GANDA SAPUTRA';
		// PDF::writeHTML($text, true, 0, true, 0);
		// // PDF::Image('images/tcpdf_signature.png', 180, 60, 15, 15, 'PNG');
		// PDF::setSignatureAppearance(180, 60, 15, 15);
		// PDF::addEmptySignatureAppearance(180, 80, 15, 15);
		
		/* Kosongan */
		
		$pages = PDF::setSourceFile($filekosongan);
		
		for ($i = 1; $i <= $pages; $i++)
    	{
			PDF::AddPage();
			$page = PDF::importPage($i);
			PDF::useTemplate($page, 0, 0);
			PDF::setSignature($public, $private, 'X8HCRIAD', '' , 2, $info);
		}
		
		PDF::Output('/Users/aelgees/PIDUITEUN/php/dgsign/BABA.pdf', 'F');
	}
	

}