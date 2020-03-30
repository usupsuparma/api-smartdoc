<?php namespace App\Modules\Review\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface ReviewInterface extends RepositoryInterface
{
    public function data($request);

	public function show($id);
	
	public function data_detail($request, $review_id);

    public function show_detail($id);
    
	public function create_detail($request, $review_id);
	
	public function update_detail($request, $id);
	
	public function delete_detail($id);
}