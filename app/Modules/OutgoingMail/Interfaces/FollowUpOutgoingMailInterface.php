<?php namespace App\Modules\OutgoingMail\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface FollowUpOutgoingMailInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function follow_up($request, $id);
}