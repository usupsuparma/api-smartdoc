<?php namespace App\Modules\External\Organization\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface OrganizationInterface extends RepositoryInterface
{	
	public function options();
	
	public function option_disposition($incoming_mail_id);
}