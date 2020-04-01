<?php namespace App\Modules\Signature\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Signature\Repositories\SignatureRepositories;
use Authority, Auth, Storage;

class SignatureController extends BaseController 
{
	private $signatureRepository;
	
	public function __construct(SignatureRepositories $signatureRepository) 
	{
		$this->signatureRepository = $signatureRepository;
		Authority::acl_access(Auth::user(), 'digital-signatures');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->signatureRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne($this->signatureRepository->show($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->signatureRepository->create($request), 200); 
	}
	
	public function update(Request $request, $id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->signatureRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->signatureRepository->delete($id), 200); 
	}
	
	public function download($id)
    {
		$path = storage_path('app/public'. $this->signatureRepository->download($id));

		return response()->download($path);
    }
}