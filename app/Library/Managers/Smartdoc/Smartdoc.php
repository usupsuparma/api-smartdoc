<?php namespace App\Library\Managers\Smartdoc;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use PDF;

class Smartdoc extends PDF
{
	protected $company_name;
	protected $company_address_1;
	protected $company_address_2;
	protected $company_address_3;
	protected $company_contact;
	
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