<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Modules\IncomingMail\Models\IncomingMailModel;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use Exception;
use Illuminate\Console\Command;

/**
 * Class createArchiveIncomingCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class CreateArchiveIncomingCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "archive:incoming";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create Archive Incoming Mail";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
			$incomings = IncomingMailModel::isDone()
						->isNotArchive()
						->get();
						
			if ($incomings->isEmpty()) {
				$this->info("Specific Data Archive not found.");
				return;
			}
			
			foreach ($incomings as $om) {
				$update = IncomingMailModel::find($om->id);
				
				if ($update) {
					$update->update([
						'is_archive' => IncomingMailStatusConstans::IS_ARCHIVE
					]);
					$this->info("Create Archive Incoming Mail ID ". $om->id . " success");
				}
			}
			
			$this->info("Create Data Archive Incoming Mail is Succesfully");
			
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}