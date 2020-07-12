<?php namespace App\Modules\Sync\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface SyncInterface extends RepositoryInterface
{
	public function data();
	
	public function generate_sync();
	
	public function generate_token_client();
}