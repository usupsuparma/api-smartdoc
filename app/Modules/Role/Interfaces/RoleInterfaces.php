<?php namespace App\Modules\Role\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface RoleInterface extends RepositoryInterface
{
    public function data($request);

	public function show($id);
	
    public function showMenu();
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
}