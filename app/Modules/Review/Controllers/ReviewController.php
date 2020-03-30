<?php namespace App\Modules\Review\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Review\Repositories\ReviewRepositories;
use Authority, Auth;

class ReviewController extends BaseController 
{
	private $reviewRepository;
	
	public function __construct(ReviewRepositories $reviewRepository) 
	{
		$this->reviewRepository = $reviewRepository;
		Authority::acl_access(Auth::user(), 'reviews');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->reviewRepository->data($request), 200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne($this->reviewRepository->show($id), 200);
	}
	
	public function data_detail(Request $request, $id)
	{
		Authority::check('read');
		
		return $this->showAll($this->reviewRepository->data_detail($request, $id), 200);
	}
	
	public function show_detail($review_id, $id)
	{
		Authority::check('read');
		return $this->showOne($this->reviewRepository->show_detail($id), 200);
	}
	
	public function create_detail(Request $request, $id)
	{
		Authority::check('create');
		
        return $this->successResponse($this->reviewRepository->create_detail($request, $id), 200); 
	}
	
	public function update_detail(Request $request, $id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->reviewRepository->update_detail($request, $id), 200); 
	}
	
	public function delete_detail($review_id, $id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->reviewRepository->delete_detail($id), 200); 
    }
}