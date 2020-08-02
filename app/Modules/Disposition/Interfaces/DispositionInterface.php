<?php namespace App\Modules\Disposition\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface DispositionInterface extends RepositoryInterface
{
    public function data($request);

    public function show($id);
    
	public function create($request);
	
	public function update($request, $id);
	
	public function delete($id);
	
	public function download_incoming($incoming_mail_id);
	
	public function download_main($id);
	
	public function download_follow($follow_id);
	
	public function detail_disposition($id);
}