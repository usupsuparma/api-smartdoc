<?php namespace App\Modules\Master\Type\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface TypeInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
	
	public function select_type();
}