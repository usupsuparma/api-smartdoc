<?php

namespace App\Modules\IncomingMail\Models;

/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\IncomingMail\Models\IncomingMailModel;

use Upload;

class IncomingMailFollowUp extends Model
{

	protected $table = 'incoming_mails_follow_up';

	protected $fillable   = [
		'incoming_mail_id', 'employee_id', 'description', 'path_to_file', 'status'
	];

	public function employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'employee_id', 'nik');
	}

	public function incoming()
	{
		return $this->belongsTo(IncomingMailModel::class, 'incoming_mail_id');
	}

	protected static function boot()
	{
		parent::boot();

		static::deleting(function ($followup) {
			/* Remove attachment file*/
			if (!empty($followup->path_to_file)) {
				Upload::delete($followup->path_to_file);
			}
		});
	}
}
