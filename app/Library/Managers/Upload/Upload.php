<?php namespace App\Library\Managers\Upload;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\Facades\Storage;
use GlobalHelper;
use QRcode;
use Illuminate\Support\Str;

class Upload
{	
	const STR_RANDOM = 32;
	
	public static function uploads($path, $file)
	{
		$original_name = $file->getClientOriginalName();
		$file_name = pathinfo($original_name, PATHINFO_FILENAME);
		
        $file_extension = $file->getClientOriginalExtension();
		$real_path = $file->getRealPath();
		$custom_file_name = $file_name. '_' . Str::random(self::STR_RANDOM) . '.' . $file_extension;
		
		/* Path Folder Modules */
		$ftp_path = setting_by_code('FTP_DIRECTORY_ROOT');
		$file_path = $ftp_path. $path;
		
		$process = Storage::disk('ftp')->put($file_path. $custom_file_name, file_get_contents($real_path));
		
		$fileUrl = $path. $custom_file_name;
		
		if($process){
			return $fileUrl;
		} 
		
		return NULL;
	}
	
	public static function delete($file_path)
	{
		$ftp_path = setting_by_code('FTP_DIRECTORY_ROOT');

		if (Storage::disk('ftp')->exists($ftp_path. $file_path) && !empty($file_path)) {
			$process = Storage::disk('ftp')->delete($ftp_path. $file_path);
			
			if ($process) {
				return true;
			}
			
			return false;
		}

		return true;
	}
	
	public static function download($file_path)
	{
		$ftp_path = setting_by_code('FTP_DIRECTORY_ROOT');
		/* Check File Exist in FTP */
		
		if (Storage::disk('ftp')->exists($ftp_path. $file_path)) {
			/* Check File Exist in Local Storage */
			if (!Storage::disk('public')->exists($file_path)) {
				/* Move file from FTP to Local Storage */
				Storage::disk('public')->put($file_path, Storage::disk('ftp')->get($ftp_path. $file_path));	
			}
		}
	}
	
	public static function create_qr_code($data)
	{
		$qr_path = setting_by_code('PATH_QR_CODE');
		
		$QR = QrCode::format('png')->merge('/public/assets/img/logo_qr.jpg', .2)
				->size(400)->errorCorrection('H')
				->generate($data['url']);
		
		$output_file = $qr_path. $data['type']. '-' . time() . '.png';
		
		Storage::disk('public')->put($output_file, $QR);
		
		return $output_file;
	}
	
	public static function delete_local($file)
	{
		if (Storage::disk('public')->exists($file) && !empty($file_path)) {
			$process = Storage::disk('public')->delete($file);
			
			if ($process) {
				return true;
			}
			
			return false;
		}

		return true;
	}
	
	public static function upload_local_to_ftp($file_path)
	{
		$ftp_path = setting_by_code('FTP_DIRECTORY_ROOT');
		
		if (Storage::disk('public')->exists($file_path)) {
			/* Move file from FTP to Local Storage */
			$process = Storage::disk('ftp')->put($ftp_path. $file_path, Storage::disk('public')->get($file_path));	
			
			if ($process) {
				return true;
			}
			
			return false;
		}

		return true;
	}
}