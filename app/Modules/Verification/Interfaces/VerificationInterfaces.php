<?php namespace App\Modules\Verification\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface VerificationInterface extends RepositoryInterface
{
    public function verify($request);
}