<?php namespace App\Modules\Test\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TestInterface.
 *
 * @package namespace App\Entities\Interfaces;
 */
interface TestInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
	
	public function generate($request);
	
}