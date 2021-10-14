<?php namespace App\Modules\MappingStructure\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface MappingStructureInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function update($request, $id);
}