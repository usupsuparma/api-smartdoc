<?php namespace App\Modules\MappingFollowOutgoing\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface MappingFollowOutgoingInterface extends RepositoryInterface
{
    public function data($request);
    
	public function create($request);
	
    public function delete($id);
}