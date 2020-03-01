<?php namespace App\Modules\Menu\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

interface MenuInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
}