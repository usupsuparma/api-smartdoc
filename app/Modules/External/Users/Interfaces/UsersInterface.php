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
	
	public function data_ex($request);

    public function show_ex($id);
    
	public function create_ex($request);
	
	public function update_ex($request, $id);
	
	public function delete_ex($id);
}