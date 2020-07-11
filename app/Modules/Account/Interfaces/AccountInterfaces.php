<?php namespace App\Modules\Account\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface AccountInterface extends RepositoryInterface
{
    public function show();
    
    public function change_password($request);
}