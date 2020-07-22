<?php namespace App\Modules\Dashboard\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface DashboardInterface extends RepositoryInterface
{
    public function get_count_all_mail($request);
}