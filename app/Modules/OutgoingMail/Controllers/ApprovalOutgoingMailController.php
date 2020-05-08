<?php namespace App\Modules\OutgoingMail\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\OutgoingMail\Repositories\ApprovalOutgoingMailRepositories;
use Authority, Auth;

class ApprovalOutgoingMailController extends BaseController 
{
	private $approvalOutgoingMailRepository;
	
	public function __construct(ApprovalOutgoingMailRepositories $approvalOutgoingMailRepository) 
	{
		$this->approvalOutgoingMailRepository = $approvalOutgoingMailRepository;
		Authority::acl_access(Auth::user(), 'outgoing-mails-approval');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->approvalOutgoingMailRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->successResponse($this->approvalOutgoingMailRepository->show($id),200);
	}
	
	public function update(Request $request, $id)
	{
		Authority::check('approve');
		
		$results = $this->approvalOutgoingMailRepository->update($request, $id);
		
        return $this->successResponse($results, 200);
	}
	
	public function download_attachment_approval($approval_id)
    {	
		$path = storage_path('app/public'. $this->approvalOutgoingMailRepository->download_attachment_approval($approval_id));

		return response()->download($path, basename($path));
	}
	
	public function download_review_outgoing_mail($id)
    {	
		$path = storage_path('app/public'. $this->approvalOutgoingMailRepository->download_review_outgoing_mail($id));

		return response()->download($path, basename($path));
	}
}