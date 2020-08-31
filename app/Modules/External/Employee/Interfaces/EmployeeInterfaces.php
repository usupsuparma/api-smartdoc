<?php namespace App\Modules\External\Employee\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface EmployeeInterface extends RepositoryInterface
{	
	public function options();
	
	public function option_hierarchy();	
	
	public function option_structure($id);	
	
	public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
}