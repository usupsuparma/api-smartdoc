<?php namespace App\Modules\Report\Disposition\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface ReportDispositionInterface extends RepositoryInterface
{
    public function data($request);

    public function export_data($request);
}