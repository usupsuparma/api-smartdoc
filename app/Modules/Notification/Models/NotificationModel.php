<?php namespace App\Modules\Notification\Models;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\Notification\Transformers\NotificationTransformer;
use Auth;

class NotificationModel extends Model 
{

	public $transformer = NotificationTransformer::class;
	
	protected $table = 'notifications';
	
    protected $fillable   = [
		'heading', 'title', 'content', 'data', 'redirect_web', 'redirect_mobile',
		'sender_id', 'receiver_id', 'is_read'
	];
	
	public function sender() 
	{
		return $this->belongsTo(EmployeeModel::class, 'sender_id', 'id_employee');
	}
	
	public function receiver() 
	{
		return $this->belongsTo(EmployeeModel::class, 'receiver_id', 'id_employee');
	}
	
	public function scopeIsNotRead($query)
	{
		return $query->where('status', 0);
	}
	
	public function scopeByUser($query)
	{
		return $query->where([
			'receiver_id' => Auth::user()->user_core->id_employee,
			'is_read' => false,
		]);
	}
	
	public function scopeReadNotif($query, $id)
	{
		return $query->where([
			'receiver_id' => Auth::user()->user_core->id_employee,
			'id' => $id,
			'is_read' => false
		]);
	}
	
	public function getDataAttribute($data)
	{
		return unserialize($data);
	}
	
}