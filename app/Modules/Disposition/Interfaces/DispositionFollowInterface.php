<?php namespace App\Modules\Disposition\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface DispositionFollowInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
    public function show_follow_up($id);
    
    public function follow_up($request, $id);
    
    public function download($id);
	
}