<?php namespace App\Modules\OutgoingMail\Route;

use Laravel\Lumen\Application;
use App\Library\Bases\BaseRoutes;

class ApprovalOutgoingMailRoutes extends BaseRoutes
{
	public function __construct()
	{
		$this->controller_ns = 'App\Modules\OutgoingMail\Controllers';
		$this->route_prefix = BaseRoutes::GLOBAL_PREFIX . '/outgoing-mails-approval';
	}

	public function bind(Application $app)
	{
		$app->router->group([
			'prefix' => $this->route_prefix,
			'namespace' => $this->controller_ns,
			'middleware' => 'auth'
		], function () use ($app) {
			$app->router->get('/', [
				'as' => $this->route_prefix . '.data',
				'uses' => 'ApprovalOutgoingMailController@data'
			]);
			
			$app->router->get('/{id}', [
				'as' => $this->route_prefix . '.show',
				'uses' => 'ApprovalOutgoingMailController@show'
			]);
			
			$app->router->post('/{id}', [
				'as' => $this->route_prefix . '.update',
				'uses' => 'ApprovalOutgoingMailController@update'
			]);
			
			$app->router->get('/download/attachment-approval/{approval_id}', [
				'as' => $this->route_prefix . '.download_attachment_approval',
				'uses' => 'ApprovalOutgoingMailController@download_attachment_approval'
			]);
			
			$app->router->get('/download/review-outgoing-mail/{id}', [
				'as' => $this->route_prefix . '.download_review_outgoing_mail',
				'uses' => 'ApprovalOutgoingMailController@download_review_outgoing_mail'
			]);
	
		});
	}
}
