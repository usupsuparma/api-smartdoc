<?php namespace App\Modules\SpecialDivisionOutgoing\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface SpecialDivisionOutgoingInterface extends RepositoryInterface
{
    public function data($request);
    
	public function create($request);
	
    public function delete($id);
}