<?php namespace App\Modules\Account\Controllers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Http\Request;
use App\Library\Bases\BaseController;
use App\Modules\Account\Repositories\AccountRepositories;

class AccountController extends BaseController 
{
	private $accountRepository;
	
	public function __construct(AccountRepositories $accountRepository) 
	{
		$this->accountRepository = $accountRepository;
	}
	
	public function show()
	{
		return $this->showOne($this->accountRepository->show(),200);
	}
	
	public function change_password(Request $request)
	{
		return $this->successResponse($this->accountRepository->change_password($request),200);
	}
}