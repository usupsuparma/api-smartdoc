<?php namespace App\Modules\Notification\Interfaces;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Contracts\RepositoryInterface;

interface NotificationInterface extends RepositoryInterface
{
    public function notification_user();
    
    public function read_notification($id);
}