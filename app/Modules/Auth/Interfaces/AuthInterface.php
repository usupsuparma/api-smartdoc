<?php namespace App\Modules\Auth\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface AuthInterface extends RepositoryInterface
{
    public function login($request);
    
    public function refresh_token($request);

    public function logout();
}