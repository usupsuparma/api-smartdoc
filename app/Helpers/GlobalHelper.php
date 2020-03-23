<?php
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Setting\Models\SettingModel;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\External\Employee\Models\EmployeeModel;

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

if (!function_exists('core_user')) {
	
    function core_user($user_id, $employee = false)
    {
        if (($employee)) {
            return EmployeeModel::whereHas('user', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->first();
        }
        
        return ExternalUserModel::with('employee', 'structure', 'position')->find($user_id);
    }
}