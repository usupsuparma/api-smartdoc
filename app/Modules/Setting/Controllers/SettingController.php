<?php namespace App\Modules\Setting\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Setting\Models\SettingModel;
use App\Modules\Setting\Repositories\SettingRepositories;
use Authority, Auth;

class SettingController extends BaseController 
{
	private $settingRepository;
	
	public function __construct(SettingRepositories $settingRepository) 
	{
		$this->settingRepository = $settingRepository;
		Authority::acl_access(Auth::user(), 'setting');
	}
	
	public function data(Request $request)
	{
		Authority::check('read');
		
		return $this->showAll($this->settingRepository->data($request),200);
	}
	
	public function show($id)
	{
		Authority::check('read');
		
		return $this->showOne(SettingModel::findOrFail($id),200);
	}
	
	public function create(Request $request)
	{
		Authority::check('create');
		
        return $this->successResponse($this->settingRepository->create($request), 200); 
	}
	
	public function update(Request $request,$id)
    {
		Authority::check('update');
		
		return $this->successResponse($this->settingRepository->update($request, $id), 200); 
	}
	
	public function delete($id)
    {
		Authority::check('delete');
		
        return $this->successResponse($this->settingRepository->delete($id), 200); 
    }
}