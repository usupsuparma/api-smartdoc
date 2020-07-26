<?php namespace App\Modules\Archive\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface ArchiveIncomingInterface extends RepositoryInterface
{
	public function data($request);
	
    public function show($id);
}