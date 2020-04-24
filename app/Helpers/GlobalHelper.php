<?php
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Setting\Models\SettingModel;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\Review\Models\ReviewModel;
use App\Modules\User\Models\UserModel;

if (!function_exists('setting_by_code')) {
	
    function setting_by_code($code)
    {
        $query = SettingModel::where([
            'code' => $code,
            'status' => 1
        ]);
        
        if ($query->exists()) {
            return $query->first()->value;
        }
        
        return NULL;
    }
}

if (!function_exists('setting_name_by_code')) {
	
    function setting_name_by_code($code)
    {
        $query = SettingModel::where([
            'code' => $code,
            'status' => 1
        ]);
        
        if ($query->exists()) {
            return !empty($query->firstOrFail()) ? $query->firstOrFail()->name : NULL;
        }
        
        return NULL;
    }
}

if (!function_exists('core_user')) {
	
    function core_user($user_id, $employee = false)
    {
        if (($employee)) {
            return EmployeeModel::whereHas('user', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->first();
        }
        
        return ExternalUserModel::with('employee', 'structure', 'position')->findOrFail($user_id);
    }
}

if (!function_exists('smartdoc_user')) {
	
    function smartdoc_user($user_core_id)
    {
        $users = UserModel::where('user_core_id', $user_core_id)->first();

        if ($users) {
            return $users;
        }
        
        return NULL;
    }
}

if (!function_exists('employee_user')) {
	
    function employee_user($employee_id)
    {
        return EmployeeModel::whereHas('user', function ($q) use ($employee_id) {
                $q->where('id_employee', $employee_id);
        })->firstOrFail();
    }
}

if (!function_exists('review_list')) {
	
    function review_list($code_review)
    {
        $results = [];
        $orgs = [];
        
        $review = ReviewModel::where('code', $code_review)->first();
        
        if (!empty($review)) {
            $details = !empty($review->details) ? $review->details : [];
            
            foreach ($details as $dt) {
                $orgs[] = $dt->organizations->id;
            }
        }
        $users = ExternalUserModel::isActive()
            ->whereIn('kode_struktur', $orgs)
            ->whereIn('kode_jabatan', unserialize(setting_by_code('ALLOW_ROLE_POSITION_USER')));
        
        if (!$users->exists()) {
            return false;
        }
        
        $collections = $users->orderBy('kode_jabatan', 'DESC')->get();
        
        foreach ($details as $dt) {
            foreach ($collections as $col) {
                if ($dt->organizations->kode_struktur === $col->structure->kode_struktur) {
                    $results[] = [
                        'structure_id' => $dt->structure_id,
                        'employee_id' => $col->id_employee
                    ];
                }
            }
        }
        
        return $results;
    }
}

if (!function_exists('review_list_non_director')) {
	
    function review_list_non_director($list_code_hierarchy)
    {
        $results = [];
        $orgs = [];
        
        if (!empty($list_code_hierarchy)) {
            
            foreach ($list_code_hierarchy as $dt) {
                $orgs[] = $dt->id;
            }
        }
        
        $users = ExternalUserModel::isActive()
                ->whereIn('kode_struktur', $orgs)
                ->whereIn('kode_jabatan', unserialize(setting_by_code('ALLOW_ROLE_POSITION_USER')));
        
        if (!$users->exists()) {
            return false;
        }
        
        $collections = $users->orderBy('kode_jabatan', 'DESC')->get();
        
        foreach ($list_code_hierarchy as $dt) {
            foreach ($collections as $col) {
                if ($dt->kode_struktur === $col->structure->kode_struktur) {
                    $results[] = [
                        'structure_id' => $dt->id,
                        'employee_id' => $col->id_employee
                    ];
                }
            }
        }
        
        return $results;
    }
}

if (!function_exists('body_email')) {
	
    function body_email($model, $category, $action_mail)
    {
        $body = config('constans.email.'. $action_mail);
		$origin = ['#category#', '#subject#'];
        $replace   = [$category, $model->subject_letter];
        
		return str_replace($origin, $replace, $body);
    }
}

if (!function_exists('body_email_in')) {
	
    function body_email_in($model, $category, $action_mail)
    {
        $body = config('constans.email-in.'. $action_mail);
		$origin = ['#category#', '#subject#'];
        $replace   = [$category, $model->subject_letter];
        
		return str_replace($origin, $replace, $body);
    }
}