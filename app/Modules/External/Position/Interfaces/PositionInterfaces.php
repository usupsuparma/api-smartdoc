<?php namespace App\Modules\External\Position\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface PositionInterface extends RepositoryInterface
{	
	public function options();
	
	public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
}