<?php namespace App\Modules\Test\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Test\Interfaces\TestInterface;
use App\Modules\Test\Models\TestModel;
use Validator;
use Smartdoc;
use Upload;

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
		$data_qr = [
			'type' => setting_by_code('SURAT_KELUAR'),
			'url' => setting_by_code('BASE_URL_FRONT_END')
		];
		
		$createQR = Upload::create_qr_code($data_qr);
		
		$data = [
			'image_qr' => $createQR
		];
		
		Smartdoc::generate($data, $request->body);
		
		Upload::delete_local($createQR);
	}
    
}
