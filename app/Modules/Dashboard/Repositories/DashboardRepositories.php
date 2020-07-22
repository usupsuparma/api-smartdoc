<?php namespace App\Modules\Dashboard\Repositories;
/**
 * Class DashboardRepositories.
 * @author  Adam Lesmana Ganda Saputra <aelgees.dev@gmail.com>
 */

use Prettus\Repository\Eloquent\BaseRepository;
use App\Modules\Dashboard\Interfaces\DashboardInterface;
use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\IncomingMail\Models\IncomingMailModel;
use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use DB;

class DashboardRepositories extends BaseRepository implements DashboardInterface
{
	public function model()
	{
		return OutgoingMailModel::class;
	}
	
    public function get_count_all_mail($request)
    {
		/* Outgoing Mail */
		$outgoingMail = $this->model->select(
			DB::raw(
				'count(*) as total, 
				CAST(SUM(status = '.OutgoingMailStatusConstants::REVIEW.') as UNSIGNED) as totalReview,
				CAST(SUM(status = '.OutgoingMailStatusConstants::APPROVED.') as UNSIGNED) as totalApproved,
				CAST(SUM(status = '.OutgoingMailStatusConstants::SIGNED.') as UNSIGNED) as totalSigned,
				CAST(SUM(status = '.OutgoingMailStatusConstants::PUBLISH.') as UNSIGNED) as totalPublish'
			)
		)
		->categoryReport()
		->whereBetween('letter_date', [
			$request->start_date, 
			$request->end_date
		])->get()->toArray();
		
		/* Incoming Mail */
		$incomingMail = IncomingMailModel::select(
			DB::raw(
				'count(*) as total, 
				CAST(SUM(status = '.IncomingMailStatusConstans::SEND.') as UNSIGNED) as totalOnProgress,
				CAST(SUM(status = '.IncomingMailStatusConstans::DONE.') as UNSIGNED) as totalDone,
				CAST(SUM(is_read = 1) as UNSIGNED) as totalIsRead,
				CAST(SUM(is_read = 0) as UNSIGNED) as totalIsNotRead'
			)
		)
		->whereIn('status', [
			IncomingMailStatusConstans::SEND,
			IncomingMailStatusConstans::DONE
		])
		->whereBetween('letter_date', [
			$request->start_date, 
			$request->end_date
		])->get()->toArray();
		
		/* Disposition Mail */
		$dispositionMail = DispositionModel::select(
			DB::raw(
				'count(*) as total, 
				CAST(SUM(status = '.IncomingMailStatusConstans::DISPOSITION.') as UNSIGNED) as totalOnProgress,
				CAST(SUM(status = '.IncomingMailStatusConstans::DONE.') as UNSIGNED) as totalDone,
				(SELECT CAST(SUM(is_read = true) as UNSIGNED) FROM smc_dispositions_assign) as totalPeopleIsRead,
				(SELECT CAST(SUM(is_read = false) as UNSIGNED) FROM smc_dispositions_assign) as totalPeopleIsNotRead'
			)
		)
		->whereIn('status', [
			IncomingMailStatusConstans::DISPOSITION,
			IncomingMailStatusConstans::DONE
		])
		->whereBetween('disposition_date', [
			$request->start_date, 
			$request->end_date
		])->get()->toArray();
		
		return [
			'data' => [
				'outgoing' => !empty($outgoingMail) ? $outgoingMail[0] : [],
				'incoming' => !empty($incomingMail) ? $incomingMail[0] : [],
				'disposition' => !empty($incomingMail) ? $dispositionMail[0] : [],
			]
		];
	}
}
