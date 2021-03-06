<?php namespace App\Modules\OutgoingMail\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface OutgoingMailInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
	
	public function delete_attachment($attachment_id);
	
	public function download_attachment($attachment_id);
	
	public function download_attachment_main($id);
	
	
}