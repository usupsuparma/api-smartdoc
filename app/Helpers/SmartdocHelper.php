<?php namespace App\Helpers;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */
use App\Modules\MappingStructure\Models\MappingStructureModel;
use Auth;
/**
 * Class SmartDocHelper
 */
class SmartdocHelper
{
	const CODE_DIREKTUR = "MS001";
	const CODE_DIREKSI = "MS002";
	const CODE_VP = "MS003";
	
	public static function bod_level()
	{
		$list_bod_level = [];
        $user_structure_id = Auth::user()->user_core ? Auth::user()->user_core->kode_struktur : '';
		
		/* Get Listt Structure Direktur level */
        $structure_direktur_list = MappingStructureModel::getByCode(self::CODE_DIREKTUR)->first();
        if (!empty($structure_direktur_list)) {
            foreach ($structure_direktur_list->details as $sd) {
                $list_bod_level[] = $sd->id;
            }
        }
		
		/* Get Listt Structure direksi level */
        $structure_direksi_list = MappingStructureModel::getByCode(self::CODE_DIREKSI)->first();
        if (!empty($structure_direksi_list)) {
            foreach ($structure_direksi_list->details as $sd) {
                $list_bod_level[] = $sd->id;
            }
		}
		
		if (in_array($user_structure_id, $list_bod_level)) {
			return true;
		}
		
		return false;
	}
	
	public static function direksi_vp_level()
	{
		$list_bod_level = [];
        $user_structure_id = Auth::user()->user_core ? Auth::user()->user_core->kode_struktur : '';
		
		/* Get Listt Structure Direksi level */
        $structure_direksi_list = MappingStructureModel::getByCode(self::CODE_DIREKSI)->first();
        if (!empty($structure_direksi_list)) {
            foreach ($structure_direksi_list->details as $sd) {
                $list_bod_level[] = $sd->id;
            }
        }
		
		/* Get List Structure VP level */
        $structure_vp_list = MappingStructureModel::getByCode(self::CODE_VP)->first();
        if (!empty($structure_vp_list)) {
            foreach ($structure_vp_list->details as $sd) {
                $list_bod_level[] = $sd->id;
            }
		}
		
		if (in_array($user_structure_id, $list_bod_level)) {
			return true;
		}
		
		return false;
	}
}