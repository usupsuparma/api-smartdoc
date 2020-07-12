<?php namespace App\Modules\External\Users\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface UsersInterface extends RepositoryInterface
{   
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
}