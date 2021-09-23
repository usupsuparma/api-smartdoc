<?php

/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use App\Modules\Setting\Models\SettingModel;
use App\Modules\External\Users\Models\ExternalUserModel;
use App\Modules\External\Employee\Models\EmployeeModel;
use App\Modules\Review\Models\ReviewModel;
use App\Modules\User\Models\UserModel;
use App\Modules\MappingStructure\Models\MappingStructureDetailModel;
use App\Events\NotificationMobile;
use App\Modules\Role\Models\RoleModel;
use App\Modules\SpecialDivisionOutgoing\Models\SpecialDivisionOutgoingModel;
use App\Modules\MappingStructure\Models\MappingStructureModel;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use App\Modules\External\Organization\Models\OrganizationModel;

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

    function review_list($code_review, $type_level, $hierarchy_orgs)
    {
        $results = [];
        $orgs = [];
        $positions = [];
        $list_direksi = [];
        $hierarchies = [];

        $code_review = $type_level == 'DIREKTUR' ? 'OMD' : $code_review;
        /* Special Division Bypass */
        $user_structure_id = Auth::user()->user_core ? Auth::user()->user_core->kode_struktur : '';
        $special_division = SpecialDivisionOutgoingModel::findByStructure($user_structure_id);

        /* Get Listt Structure direction level */
        $structure_direksi_list = MappingStructureModel::getByCode('MS002')->first();
        if (!empty($structure_direksi_list)) {
            foreach ($structure_direksi_list->details as $sd) {
                $list_direksi[] = $sd->id;
            }
        }

        /* Hierarchy Organization */
        if (!empty($hierarchy_orgs)) {

            /* Get Hierarchy VP to Bottom */
            foreach ($hierarchy_orgs as $sd) {
                if (!in_array(
                    $sd->kode_struktur,
                    array_merge(
                        unserialize(setting_by_code('DIREKTUR_LEVEL_STRUCTURE')),
                        unserialize(setting_by_code('DIREKSI_LEVEL_STRUCTURE'))
                    )
                )) {
                    $hierarchies[] = $sd->kode_struktur;
                    $organization = OrganizationModel::where('kode_struktur', $sd->kode_struktur)->first();

                    if ($organization) {
                        /* check mapping structure top level position */
                        $map_struct = MappingStructureDetailModel::where('structure_id', $organization->id)->first();
                        if (!empty($map_struct)) {
                            $structure = $map_struct->map_structure;

                            if (!empty($structure->primary_top_level_id)) {
                                array_push($positions, $structure->primary_top_level_id);
                            }

                            if (!empty($structure->secondary_top_level_id)) {
                                array_push($positions, $structure->secondary_top_level_id);
                            }
                        }

                        $orgs[] = $organization->id;
                    }
                }
            }

            $available_direksi = null;
            /* Get Hierarchy Director line to top */
            foreach ($hierarchy_orgs as $sd) {
                if (
                    in_array($sd->kode_struktur, unserialize(setting_by_code('DIREKSI_LEVEL_STRUCTURE')))
                ) {
                    $organization = OrganizationModel::where('kode_struktur', $sd->kode_struktur)->first();
                    $available_direksi = $organization->id;
                }
            }
        }

        $review = ReviewModel::where('code', $code_review)->first();

        if (!empty($review)) {
            $details = !empty($review->details) ? $review->details : [];

            foreach ($details as $dt) {
                /* check mapping structure top level position */
                $map_struct = MappingStructureDetailModel::where('structure_id', $dt->organizations->id)->first();
                if (!empty($map_struct)) {
                    $structure = $map_struct->map_structure;

                    if (!empty($structure->primary_top_level_id)) {
                        array_push($positions, $structure->primary_top_level_id);
                    }

                    if (!empty($structure->secondary_top_level_id)) {
                        array_push($positions, $structure->secondary_top_level_id);
                    }
                }

                $orgs[] = $dt->organizations->id;
            }
        }

        if ($available_direksi) {
            /* CARI DIREKSI YANG AKAN DI TAKEOUT */
            $takeout_direksi = array_filter(
                $list_direksi,
                function ($e) use ($available_direksi) {
                    return $e !== $available_direksi;
                }
            );
            if ($takeout_direksi) {
                $remove_direksi = array_values($takeout_direksi)[0];

                /* HAPUS DIREKSI YANG TIDAK SESUAI DENGAN GARIS LURUS */
                if (($key = array_search($remove_direksi, $orgs)) !== false) {

                    unset($orgs[$key]);
                }
            }
        }

        /* Condition if special division available */
        if ($special_division) {
            $orgs = array_diff($orgs, $list_direksi);
        }

        /* Remove duplicate array position */
        $list_position = collect($positions)->unique()->values()->all();

        $users = ExternalUserModel::isActive()
            ->whereIn('kode_struktur', $orgs)
            ->whereIn('kode_jabatan', $list_position);

        if (!$users->exists()) {
            return false;
        }

        $collections = $users->orderBy('kode_struktur', 'DESC')->get();

        foreach (array_unique($orgs) as $dt) {
            $primary = false;
            $secondary = false;
            $arr_primary = [];
            $arr_secondary = [];
            if (!empty($collections)) {
                foreach ($collections as $key => $col) {
                    /* If list organizations same with list get user */
                    if ($dt === $col->structure->id) {
                        $map_struct = MappingStructureDetailModel::where('structure_id', $dt)->first();

                        if (!empty($map_struct)) {
                            $structure = $map_struct->map_structure;

                            if (!empty($map_struct)) {

                                if (!empty($structure->primary_top_level_id)) {
                                    if ($structure->primary_top_level_id == $col->kode_jabatan) {
                                        $pr = [
                                            'structure_id' => $dt,
                                            'employee_id' => $col->id_employee
                                        ];

                                        $primary = true;
                                        $arr_primary[] = $pr;
                                    }
                                }

                                if (!empty($structure->primary_top_level_id)) {
                                    if ($structure->secondary_top_level_id == $col->kode_jabatan) {
                                        $sr = [
                                            'structure_id' => $dt,
                                            'employee_id' => $col->id_employee
                                        ];

                                        $secondary = true;
                                        $arr_secondary[] = $sr;
                                    }
                                }
                            }
                        }
                    }

                    if ($primary) {
                        $results[] = $arr_primary[0];
                        break;
                    } else if (empty($arr_primary) && $secondary && $key == count($collections) - 1) {
                        $results[] = $arr_secondary[0];
                        break;
                    }
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
        $positions = [];

        if (!empty($list_code_hierarchy)) {

            foreach ($list_code_hierarchy as $dt) {
                $map_struct = MappingStructureDetailModel::where('structure_id', $dt->id)->first();
                if (!empty($map_struct)) {
                    $structure = $map_struct->map_structure;

                    if (!empty($structure->primary_top_level_id)) {
                        array_push($positions, $structure->primary_top_level_id);
                    }

                    if (!empty($structure->secondary_top_level_id)) {
                        array_push($positions, $structure->secondary_top_level_id);
                    }
                }
                $orgs[] = $dt->id;
            }
        }
        /* Remove duplicate array position */
        $list_position = collect($positions)->unique()->values()->all();

        $users = ExternalUserModel::isActive()
            ->whereIn('kode_struktur', $orgs)
            ->whereIn('kode_jabatan', $list_position);

        if (!$users->exists()) {
            return false;
        }

        $collections = $users->orderBy('kode_jabatan', 'DESC')->get();

        foreach ($list_code_hierarchy as $dt) {
            $primary = false;
            $primary = false;
            $secondary = false;
            $arr_primary = [];
            $arr_secondary = [];
            if (!empty($collections)) {
                foreach ($collections as $key => $col) {
                    if ($dt->kode_struktur === $col->structure->kode_struktur) {
                        $map_struct = MappingStructureDetailModel::where('structure_id', $dt->id)->first();
                        $structure = $map_struct->map_structure;

                        if (!empty($map_struct)) {

                            if (!empty($structure->primary_top_level_id)) {
                                if ($structure->primary_top_level_id == $col->kode_jabatan) {
                                    $pr = [
                                        'structure_id' => $dt->id,
                                        'employee_id' => $col->id_employee
                                    ];

                                    $primary = true;
                                    $arr_primary[] = $pr;
                                }
                            }

                            if (!empty($structure->primary_top_level_id)) {
                                if ($structure->secondary_top_level_id == $col->kode_jabatan) {
                                    $sr = [
                                        'structure_id' => $dt->id,
                                        'employee_id' => $col->id_employee
                                    ];

                                    $secondary = true;
                                    $arr_secondary[] = $sr;
                                }
                            }
                        }
                    }

                    if ($primary) {
                        $results[] = $arr_primary[0];
                        break;
                    } else if (empty($arr_primary) && $secondary && $key == count($collections) - 1) {
                        $results[] = $arr_secondary[0];
                        break;
                    }
                }
            }
        }

        return $results;
    }
}

if (!function_exists('body_email')) {

    function body_email($model, $category, $action_mail)
    {
        $body = config('constans.email.' . $action_mail);
        $origin = ['#category#', '#subject#'];
        $replace   = [$category, $model->subject_letter];

        return str_replace($origin, $replace, $body);
    }
}

if (!function_exists('body_email_in')) {

    function body_email_in($model, $category, $action_mail)
    {
        $body = config('constans.email-in.' . $action_mail);
        $origin = ['#category#', '#subject#'];
        $replace   = [$category, $model->subject_disposition];

        return str_replace($origin, $replace, $body);
    }
}

if (!function_exists('flat_array')) {

    function flat_array($a, $flat = [])
    {
        $entry = [];
        foreach ($a as $key => $el) {
            if (is_array($el)) {
                $flat = flat_array($el, $flat);
            } else {
                $entry[$key] = $el;
            }
        }
        if (!empty($entry)) {
            $flat[] = (object) $entry;
        }

        return $flat;
    }
}

if (!function_exists('push_notif')) {

    function push_notif($notification_data = [])
    {
        event(new NotificationMobile($notification_data));
    }
}

if (!function_exists('find_device_mobile')) {

    function find_device_mobile($employee_id = '')
    {
        $nik = EmployeeModel::select('nik')->where('id_employee', $employee_id)->first()->nik;

        $employee =  EmployeeModel::whereHas('user', function ($q) use ($nik) {
            $q->where('nik', $nik);
        })->first();

        if (!$employee && !$employee->user) {
            return null;
        }

        $user = smartdoc_user($employee->user->user_id);

        return $user && !empty($user->device_id) ? $user->device_id : NULL;
    }
}

if (!function_exists('publisher_email')) {

    function publisher_email()
    {
        $d_roles = [];
        $d_emails = [];
        $roles =  RoleModel::isPublisher()->get('id');

        if (!$roles) {
            return NULL;
        }

        foreach ($roles as $role) {
            $d_roles[] = $role->id;
        }

        $users = UserModel::whereIn('role_id', $d_roles)->get();

        if (!$users) {
            return NULL;
        }

        foreach ($users as $user) {
            $d_emails[] = [
                'email' => $user->email,
                'employee_id' => !empty($user->user_core) ? $user->user_core->id_employee : '',
            ];
        }

        return $d_emails;
    }

    if (!function_exists('source_type')) {

        function source_type($mail_category, $model)
        {
            switch ($mail_category) {
                    /* Incoming Mail */
                case 'IM':
                    $source = 'incoming';
                    $type = !empty($model->type) ? $model->type->name : '';
                    $mos = $model->source;
                    break;
                    /* Outgoing Mail */
                case 'OM':
                    $source = 'outgoing';
                    $type = !empty($model->type) ? $model->type->name : '';
                    $mos = $model->source;
                    break;
                case 'DI':
                    $source = 'incoming';
                    $type = !empty($model->incoming) ? $model->incoming->type->name : '';
                    $mos = !empty($model->incoming) ? $model->incoming->source : '';
                    break;
            }

            $src =  config('constans.source-' . $source . '.' . $mos);
            return "[{$src} - {$type}] -";
        }
    }
}
