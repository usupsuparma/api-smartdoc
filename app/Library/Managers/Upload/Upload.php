<?php namespace App\Library\Managers\Upload;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Illuminate\Support\Facades\Storage;
use GlobalHelper;

class Upload
{	
	public static function uploads($path, $file)
	{
		$original_name = $file->getClientOriginalName();
		$file_name = pathinfo($original_name, PATHINFO_FILENAME);
		
        $file_extension = $file->getClientOriginalExtension();
		$real_path = $file->getRealPath();
		$custom_file_name = $file_name. '_' . date('Ymdhis') . '.' . $file_extension;
		
		/* Path Folder Modules */
		$ftp_path = setting_by_code('FTP_DIRECTORY_ROOT');
		$file_path = $ftp_path. $path;
		
		$process = Storage::disk('sftp')->put($file_path. $custom_file_name, file_get_contents($real_path));
		
		$fileUrl = $path. $custom_file_name;
		
		if($process){
			return $fileUrl;
		} 
		
		return NULL;
	}
	
	public static function delete($file_path)
	{
		$ftp_path = setting_by_code('FTP_DIRECTORY_ROOT');

		if (Storage::disk('sftp')->exists($ftp_path. $file_path)) {
			$process = Storage::disk('sftp')->delete($ftp_path. $file_path);
			
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
		if (Storage::disk('sftp')->exists($ftp_path. $file_path)) {
			/* Check File Exist in Local Storage */
			if (Storage::disk('public')->exists($file_path)) {
				/* Move file from FTP to Local Storage */
				Storage::disk('public')->put($file_path, Storage::disk('sftp')->get($ftp_path. $file_path));	
			}
		}
	}
}