<?php namespace App\Modules\IncomingMail\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface IncomingMailInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function follow_up($request, $id);
	
	public function delete($id);
	
	public function download_attachment_main($attachment_id);
	
	public function delete_attachment($attachment_id);
	
	public function download_attachment($attachment_id);
}