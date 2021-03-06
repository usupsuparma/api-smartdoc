<?php namespace App\Listeners;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Events\Notif;
use App\Modules\Notification\Models\NotificationModel;
use App\Constants\MailCategoryConstants;
use Auth;

class NotifSender
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
     * @param  Notif  $event
     * @return void
     */
    public function handle(Notif $event)
    { 
        $notif = $event->notif;
        $subject = $notif['subject'];
        $type = isset($notif['type']) ? $notif['type'] : '';
        
        switch ($notif['heading']) {
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
        
        switch ($notif['title']) {
            case 'approval' :
                $title = 'Approval';
                $message = "{$type} ({$subject}) memerlukan persetujuan anda .";
                break;
                
            case 'signed' :
                $title = 'Signed';
                $message = "{$type} ({$subject}) memerlukan tanda tangan anda .";
                break;
                
            case 'pre-publish' :
                $title = 'Pre Publish' ;
                $message = "{$type} ({$subject}) sudah di tandatangani dan sudah siap untuk di terbitkan .";
                break;
            
            case 'publish' :
                $title = 'Publish' ;
                $message = "{$type} ({$subject}) sudah diterbitkan .";
                break;
                
            case 'follow-up-outgoing' :
                $title = 'Follow Up' ;
                $message = "{$type} ({$subject}) memerlukan tindak lanjut anda .";
                break;
            
            case 'follow-up-incoming' :
                $title = 'Follow Up' ;
                $message = "{$type} ({$subject}) memerlukan tindak lanjut anda .";
                break;
                
            case 'follow-up-disposition' :
                $title = 'Follow Up' ;
                $message = "{$type} ({$subject}) memerlukan tindak lanjut anda .";
                break;
            
            case 'finish-follow-up-disposition' :
                $title = 'Finish Follow Up Disposition' ;
                $message = "{$type} ({$subject}) sudah dilakukan tindak lanjut oleh ". $notif['employee_name'];
                break;
                
            case 'finish-follow-up-outgoing' :
                $title = 'Finish Follow Up Outgoing Mail' ;
                $message = "{$type} ({$subject}) sudah dilakukan tindak lanjut oleh ". $notif['employee_name'];
                break;
                
            case 'reject' :
                $title = 'Reject' ;
                $subject = $notif['subject'];
                $message = "{$type} ({$subject}) ditolak , harap periksa kembali umpan balik untuk surat tersebut.";
                break;
        }
        
        NotificationModel::create([
            'heading' => $heading,
            'title' => $title,
            'content' => $message,
            'data' => serialize($notif['data']),
            'redirect_web' => $notif['redirect_web'],
            'redirect_mobile' => $notif['redirect_mobile'],
            'sender_id' => Auth::user()->user_core->id_employee,
            'receiver_id' => $notif['receiver_id'],
            'is_read' => false
        ]);
    }
}
