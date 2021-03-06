<?php

namespace App\Modules\OutgoingMail\Models;

/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\OutgoingMail\Transformers\OutgoingMailTransformer;
use App\Modules\OutgoingMail\Models\OutgoingMailAttachment;
use App\Modules\OutgoingMail\Models\OutgoingMailApproval;
use App\Modules\OutgoingMail\Models\OutgoingMailForward;
use App\Modules\Master\Type\Models\TypeModel;
use App\Modules\Master\Classification\Models\ClassificationModel;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\External\Organization\Models\OrganizationModel;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use App\Modules\Signature\Models\SignatureModel;
use App\Modules\OutgoingMail\Models\OutgoingMailAssign;
use App\Modules\MappingFollowOutgoing\Models\MappingFollowOutgoingModel;
use Auth, DB;

class OutgoingMailModel extends Model
{
	use SoftDeletes;

	public $transformer = OutgoingMailTransformer::class;

	protected $table = 'outgoing_mails';

	protected $fillable   = [
		'subject_letter', 'number_letter', 'type_id', 'classification_id', 'letter_date', 'to_employee_id',
		'from_employee_id', 'body', 'status', 'signed', 'retension_date', 'is_archive', 'source', 'path_to_file', 'current_approval_employee_id', 'current_approval_structure_id', 'created_by_employee', 'created_by_structure', 'publish_by_employee', 'publish_date'
	];

	protected $dates = ['deleted_at'];

	public function assign()
	{
		return $this->hasMany(OutgoingMailAssign::class, 'outgoing_mail_id', 'id');
	}

	public function attachments()
	{
		return $this->hasMany(OutgoingMailAttachment::class, 'outgoing_mail_id', 'id');
	}

	public function approvals()
	{
		return $this->hasMany(OutgoingMailApproval::class, 'outgoing_mail_id', 'id');
	}

	public function forwards()
	{
		return $this->hasMany(OutgoingMailForward::class, 'outgoing_mail_id', 'id');
	}

	public function type()
	{
		return $this->belongsTo(TypeModel::class, 'type_id');
	}

	public function classification()
	{
		return $this->belongsTo(ClassificationModel::class, 'classification_id');
	}

	public function to_employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'to_employee_id', 'nik');
	}

	public function from_employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'from_employee_id', 'nik');
	}

	public function current_approval_employee()
	{
		return $this->belongsTo(EmployeeModel::class, 'current_approval_employee_id', 'nik');
	}

	public function created_by()
	{
		return $this->belongsTo(EmployeeModel::class, 'created_by_employee', 'nik');
	}

	public function structure_by()
	{
		return $this->belongsTo(OrganizationModel::class, 'created_by_structure');
	}

	public function signature()
	{
		return $this->belongsTo(SignatureModel::class, 'from_employee_id', 'employee_id');
	}

	public function history_approvals()
	{
		return $this->hasMany(OutgoingMailApproval::class, 'outgoing_mail_id', 'id')
			->whereNotNull('status_approval');
	}

	public function scopeAuthorityData($query)
	{
		$structure_id = Auth::user()->user_core->structure->id;

		if (Auth::user()->role->categories === 'management') {
			return $query->where('created_by_structure', $structure_id);
		}

		return $query;
	}

	public function scopeByEmployeId($query)
	{
		$nik = Auth::user()->user_core->employee->nik;
		return $query->where('current_approval_employee_id', $nik);
	}

	public function scopeMaxNumber($query, $format)
	{
		return $query->select(DB::raw('max(number_letter) as max_number'))
			->where('number_letter', 'like', "%{$format}%")
			->whereMonth('created_at', date('m'))
			->whereYear('created_at', date('Y'))
			->first();
	}

	public function scopeSignedEmployee($query)
	{
		$employee_id = Auth::user()->user_core->employee->nik;
		return $query->where([
			'from_employee_id' => $employee_id,
			'status' => OutgoingMailStatusConstants::APPROVED,
		]);
	}

	public function scopeReadyPublish($query)
	{
		return $query->where([
			'status' => OutgoingMailStatusConstants::SIGNED,
		]);
	}

	public function scopeIsPublish($query)
	{
		return $query->where([
			'status' => OutgoingMailStatusConstants::PUBLISH,
		]);
	}

	public function scopeCategoryReport($query)
	{
		$category = [
			OutgoingMailStatusConstants::REVIEW,
			OutgoingMailStatusConstants::APPROVED,
			OutgoingMailStatusConstants::SIGNED,
			OutgoingMailStatusConstants::PUBLISH
		];

		return $query->whereIn('status', $category);
	}

	public function scopeFollowUpEmployee($query)
	{
		$ids = [];
		$mapping = MappingFollowOutgoingModel::get('type_id');

		foreach ($mapping as $map) {
			$ids[] = $map->type_id;
		}

		$employee_id = Auth::user()->user_core->employee->id_employee;

		return $query->whereHas('assign', function ($q) use ($employee_id) {
			$q->where('employee_id', $employee_id);
		})->where([
			'status' => OutgoingMailStatusConstants::PUBLISH,
		])
			->whereIn('type_id', $ids);
	}

	public function scopeIsArchive($query)
	{
		return $query->where('is_archive', OutgoingMailStatusConstants::IS_ARCHIVE);
	}

	public function scopeIsNotArchive($query)
	{
		return $query->where('is_archive', OutgoingMailStatusConstants::IS_NOT_ARCHIVE);
	}

	protected static function boot()
	{
		parent::boot();

		static::deleting(function ($mails) {
			/* Remove relation attachment */
			foreach ($mails->attachments()->get() as $attachment) {
				$attachment->delete();
			}

			/* Remove relation approvals */
			foreach ($mails->approvals()->get() as $approval) {
				$approval->delete();
			}

			/* Remove relation forwards */
			foreach ($mails->forwards()->get() as $forward) {
				$forward->delete();
			}
		});
	}
}
