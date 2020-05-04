<?php namespace App\Modules\Verification\Repositories;
/**
 * Class VerificationRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Verification\Interfaces\VerificationInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\Verification\Transformers\OMTransformer;
use App\Modules\Verification\Transformers\DISPOTransformer;
use Illuminate\Support\Facades\Crypt;

class VerificationRepositories extends BaseRepository implements VerificationInterface
{	
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function verify($request)
    {
		$param = true;

		if (!$request->has('scode') && empty($request->scode)) {
			$param = false;
		}
		
		if (!$request->has('skey') && empty($request->skey)) {
			$param = false;
		}
		
		if (!$param) {
			return [
				'message' => 'Link Verifikasi Tidak Valid',
				'status' => false
			];
		}
		
		$id = Crypt::decrypt($request->skey);
		$data = [];
		switch ($request->scode) {
			case 'OM':
				$query = OutgoingMailModel::isPublish()->find($id);
				if (!empty($query)) {
					$data = OMTransformer::customTransform($query);
				}
				
				break;
			
			case 'DISPO':
				$query = DispositionModel::isDisposition($id)->first();
				
				if (!empty($query)) {
					$data = DISPOTransformer::customTransform($query);
				}
				
				break;
		}
		if (empty($query)) {
			return [
				'message' => 'Dokumen tidak ditemukan',
				'status' => false
			];
		}
		
		return [
			'data' => $data,
			'verify_type' => $request->scode,
			'status' => true
		]; 
	}
}
