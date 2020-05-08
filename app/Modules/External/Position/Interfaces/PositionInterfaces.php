<?php namespace App\Modules\External\Position\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface PositionInterface extends RepositoryInterface
{	
	public function options();
}