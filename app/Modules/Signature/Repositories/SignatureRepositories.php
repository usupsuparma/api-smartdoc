<?php namespace App\Modules\Signature\Repositories;
/**
 * Class SignatureRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Signature\Interfaces\SignatureInterface;
use App\Modules\Signature\Models\SignatureModel;
use Validator;
use Upload;

class SignatureRepositories extends BaseRepository implements SignatureInterface
{
	public function model()
	{
		return SignatureModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->where('status', $request->status);
		
		if ($request->has('name') && !empty($request->name)) {
			$query->whereHas('employees', function ($q) use ($request) {
				$q->where('name', 'like', "%{$request->name}%");
            });
		}
		
		return $query->get();
	}
	
	public function show($id)
    {
        return $this->model->findOrFail($id);
	}
	
	public function create($request)
    {
		Validator::extend('validate_file_p12', function ($attribute, $value, $parameters) use ($request) {
			if ($request->hasFile('attachment')) {
				if ($request->attachment->getClientMimeType() === 'application/x-pkcs12') {
					return true;
				}
				
				return false;
			}
			
            return true;
		});
		
		$rules = [
			'employee_id' => 'required|unique:digital_signatures,employee_id,NULL,id',
			'attachment' => 'required|validate_file_p12',
			'status' => 'required'
		];
		
		$message = [
			'attachment.validate_file_p12' => 'File harus berupa berkas berjenis: .p12'	
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_SIGNATURE'), $request->attachment);
		
		$model = $this->model->create($request->merge([
			'path_to_file' => !empty($upload) ? $upload : null
		])->all());

		created_log($model);
		
		return ['message' => config('constans.success.created')];
	}
	
	public function update($request, $id)
    {
		
		Validator::extend('validate_file_p12', function ($attribute, $value, $parameters) use ($request) {
			if ($request->hasFile('attachment')) {
				if ($request->attachment->getClientMimeType() === 'application/x-pkcs12') {
					return true;
				}
				
				return false;
			}
			
            return true;
		});
		
		$rules = [
			'employee_id' => 'required|unique:digital_signatures,employee_id,' . $id,
			'attachment' => 'validate_file_p12',
			'status' => 'required'
		];
		
		$message = [
			'attachment.validate_file_p12' => 'File harus berupa berkas berjenis: .p12'	
		];
		
		Validator::validate($request->all(), $rules, $message);
		
		$model = $this->model->findOrFail($id);
		
		$upload = $model->path_to_file;
		
		if ($request->hasFile('attachment')) {
			Upload::delete($upload);
			$upload = Upload::uploads(setting_by_code('PATH_DIGITAL_SIGNATURE'), $request->attachment);
		}
		
		
		$model->update($request->merge([
			'path_to_file' => $upload
		])->all());
		
		updated_log($model);
		
		return ['message' => config('constans.success.updated')];
	}
	
	public function delete($id)
    {
		$model = $this->model->findOrFail($id);
		deleted_log($model);
		$model->delete();
		
		return ['message' => config('constans.success.deleted')];
	}
	
	public function download($id)
    {
		$model = $this->model->findOrFail($id);
		Upload::download($model->path_to_file);
		
		return $model->path_to_file;
    }
}
