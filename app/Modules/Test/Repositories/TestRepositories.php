<?php namespace App\Modules\Test\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Test\Interfaces\TestInterface;
use App\Modules\Test\Models\TestModel;
use Validator;
use PDF;

/**
 * Class TestRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

class TestRepositories extends BaseRepository implements TestInterface
{
	public function model()
	{
		return TestModel::class;
	}
	
    public function data($request)
    {
        return $this->model->get();
	}
	
	public function show($id)
    {
        return $this->model->findOrFail($id);
	}
	
	public function create($request)
    {
		$rules = [
			'name' => 'required',
			'email' => 'required|unique:tests,email',
			'description' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		return $this->model->create($request->all())->id;
	}
	
	public function update($request, $id)
    {
		$rules = [
			'name' => 'required',
			'email' => 'required|unique:tests,email,' . $id,
			'description' => 'required',
		];
		
		Validator::validate($request->all(), $rules);
		
		$this->model->findOrFail($id)->update($request->all());
		
		return $id;
	}
	
	public function delete($id)
    {
		$query = $this->model->findOrFail($id)->delete();
		
		return $query;
	}
	
	public function generate($request)
    {
		$public = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/public_key.pem';
		$private = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/private_key.pem';
		$filekosongan = 'file:///Users/aelgees/PIDUITEUN/php/dgsign/ADAM_TEST_KOSONGAN.pdf';
		
		
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
		
		PDF::Output('ADAM_TEST_HASIL.pdf', 'D');
	}
    
}
