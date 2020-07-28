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
				IFNULL(CAST(SUM(status = '.OutgoingMailStatusConstants::REVIEW.') as UNSIGNED), 0) as totalReview,
				IFNULL(CAST(SUM(status = '.OutgoingMailStatusConstants::APPROVED.') as UNSIGNED), 0) as totalApproved,
				IFNULL(CAST(SUM(status = '.OutgoingMailStatusConstants::SIGNED.') as UNSIGNED), 0) as totalSigned,
				IFNULL(CAST(SUM(status = '.OutgoingMailStatusConstants::PUBLISH.') as UNSIGNED), 0) as totalPublish'
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
				IFNULL(CAST(SUM(status = '.IncomingMailStatusConstans::SEND.') as UNSIGNED), 0) as totalOnProgress,
				IFNULL(CAST(SUM(status = '.IncomingMailStatusConstans::DONE.') as UNSIGNED), 0) as totalDone,
				IFNULL(CAST(SUM(is_read = 1) as UNSIGNED), 0) as totalIsRead,
				IFNULL(CAST(SUM(is_read = 0) as UNSIGNED), 0) as totalIsNotRead'
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
				IFNULL(CAST(SUM(status = '.IncomingMailStatusConstans::DISPOSITION.') as UNSIGNED), 0) as totalOnProgress,
				IFNULL(CAST(SUM(status = '.IncomingMailStatusConstans::DONE.') as UNSIGNED), 0) as totalDone,
				IFNULL((SELECT CAST(SUM(is_read = true) as UNSIGNED) FROM smc_dispositions_assign), 0) as totalPeopleIsRead,
				IFNULL((SELECT CAST(SUM(is_read = false) as UNSIGNED) FROM smc_dispositions_assign), 0) as totalPeopleIsNotRead'
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
