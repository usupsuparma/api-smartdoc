<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\Notification;
use App\Modules\Notification\Models\NotificationModel;
use App\Constants\MailCategoryConstants;
use Auth;

class Notification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Handle the event.
     *
     * @param  Notification  $event
     * @return void
     */
    public function handle(Notification $event)
    { 
        $notif = $event->notif;
        
        switch ($notif->heading) {
            case MailCategoryConstants::SURAT_KELUAR :
                $heading = '[SURAT KELUAR]';
                break;
            case MailCategoryConstants::SURAT_MASUK :
                $heading = '[SURAT MASUK]' ;
                break;
            case MailCategoryConstants::SURAT_DISPOSISI :
                $heading = '[DISPOSISI SURAT]' ;
                break;
        }
        
        switch ($notif->title) {
            case 'approval' :
                $title = 'Approval';
                $subject = $notif['subject'];
                $message = $subject .' memerlukan persetujuan anda .';
                break;
            case 'signed' :
                $title = 'Signed';
                $subject = '';
                $message = $subject .' memerlukan tanda tangan anda .';
                break;
            case 'publish' :
                $title = 'Publish' ;
                $subject = '';
                $message = $subject .' sudah diterbitkan .';
                break;
            case 'follow-up-incoming' :
                $title = 'Follow Up' ;
                $subject = '';
                $message = $subject .' memerlukan tindak lanjut anda .';
                break;
            case 'follow-up-disposition' :
                $title = 'Follow Up' ;
                $subject = '';
                $message = $subject .' memerlukan tindak lanjut anda .';
                break;
            case 'reject' :
                $title = 'Reject' ;
                $subject = '';
                $message = $subject .' ditolak , harap periksa kembali umpan balik untuk surat tersebut.';
                break;
        }

        NotificationModel::create([
            'heading' => $heading,
            'title' => $title,
            'content' => $message,
            'redirect_web' => $redirect_web,
            'redirect_mobile' => $redirect_mobile,
            'sender_id' => Auth::user()->user_core->id_employee,
            'receiver_id' => $receiver_id,
            'is_read' => false
        ]);
    }
}
