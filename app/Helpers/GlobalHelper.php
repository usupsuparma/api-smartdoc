<?php
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Setting\Models\SettingModel;

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