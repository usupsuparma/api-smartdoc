<?php namespace App\Library\Managers\DigitalSign;
/**
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use GlobalHelper;
use Upload;
use Illuminate\Support\Facades\Crypt;

class DigitalSign
{	
	public static function generate_ca($model, $request)
	{
		$credential = $request->credential_key;
		$file_ds = storage_path('app/public'. $model->path_to_file);
		
		$output_path = setting_by_code('PATH_DIGITAL_SIGNATURE');
		$basename = pathinfo(basename($model->path_to_file), PATHINFO_FILENAME);
		
		$private_key_name = storage_path('app/public'. $output_path .$basename. '_private.pem');
		$public_key_name = storage_path('app/public'. $output_path .$basename. '_public.pem');

		$private_key = 'openssl pkcs12 -in '. $file_ds. ' -nocerts -out '. $private_key_name . ' -nodes -password pass:'.$credential.' 2>&1' ;
		$public_key = 'openssl pkcs12 -in '. $file_ds. ' -clcerts -nokeys -out '. $public_key_name . ' -nodes -password pass:'.$credential.' 2>&1';
		
		exec($private_key, $output_pr);
		exec($public_key, $output_pb);
		
		if ($output_pr[0] != 'MAC verified OK'){
			Upload::delete_local($output_path .$basename. '_private.pem');
			Upload::delete_local($output_path .$basename. '_public.pem');
			Upload::delete_local($model->path_to_file);
			
			return false;
		}
		
		
		(new self)->update_model($model, [
			'path_private_key' => $output_path .$basename. '_private.pem',
			'path_public_key' => $output_path .$basename. '_public.pem',
			'credential_key' => Crypt::encrypt($credential)
		]);
		
		return true;
	}
	
	public static function delete_ca($model)
	{
		Upload::delete_local($model->path_to_file);
		Upload::delete_local($model->path_private_key);
		Upload::delete_local($model->path_public_key);
		
		(new self)->update_model($model, [
			'path_private_key' => NULL,
			'path_public_key' => NULL,
			'credential_key' => NULL
		]);
		
		return true;
	}
	
	private function update_model($model, array $data)
	{
		$model->update($data);
	}
}