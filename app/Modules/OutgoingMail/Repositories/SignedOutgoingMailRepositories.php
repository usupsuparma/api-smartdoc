<?php namespace App\Modules\OutgoingMail\Repositories;
/**
 * Class SignedOutgoingMailRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\OutgoingMail\Interfaces\SignedOutgoingMailInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\Signature\Models\SignatureModel;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use Validator;
use Upload, DigitalSign, Smartdoc;

class SignedOutgoingMailRepositories extends BaseRepository implements SignedOutgoingMailInterface
{
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function data($request)
    {
		$query = $this->model->signedEmployee();
		
		if ($request->has('keyword') && !empty($request->keyword)) {
			$query->where('subject_letter', 'like', "%{$request->keyword}%");
		}
		
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
		
		return $query->get();
	}
	
	public function show($id)
    {
		$data =  $this->model->signedEmployee()->where('id', $id)->firstOrFail();
		
		return ['data' => OutgoingMailTransformer::customTransform($data)];
	}
	
	public function update($request, $id)
    {
		$model = $this->model->signedEmployee()->where('id', $id)->firstOrFail();
		
		if ($request->signature_available) {
			$rules = [
				'credential_key' => 'required',
			];
			
			$message = [
				'credential_key.required' => 'Kunci Rahasia wajib diisi'	
			];
			
			Validator::validate($request->all(), $rules, $message);
		}
		
		$signatureModel = SignatureModel::where('employee_id', $model->from_employee_id)->first();
		
		if (!empty($signatureModel)) {
			Upload::download($signatureModel->path_to_file);
			$generate = DigitalSign::generate_ca($signatureModel, $request);
			
			if (!$generate) {
				return ['message' => config('constans.error.generate'), 'status' => false];
			}
		}
		
		if ($request->signature_available == 'true' && !empty($signatureModel)) {
			$document = Smartdoc::outgoing_mail_signature($model);
		}else{
			$document = Smartdoc::outgoing_mail($model);
		}
		
		$model->update([
			'signed' => !$request->signature_available ? false : true,
			'status' => OutgoingMailStatusConstants::SIGNED,
			'path_to_file' => $document,
		]);
		
		signed_log($model);
		
		return [
			'message' => config('constans.success.signed'), 
			'status' => true
		];
	} 
}
