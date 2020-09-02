<?php namespace App\Modules\External\Organization\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface OrganizationInterface extends RepositoryInterface
{	
	public function options();
	
	public function option_disposition();
	
	public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
	
	public function ordering($request);
}