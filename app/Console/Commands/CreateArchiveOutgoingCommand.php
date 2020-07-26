<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Modules\OutgoingMail\Models\OutgoingMailModel;
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use Exception;
use Illuminate\Console\Command;

/**
 * Class createArchiveOutgoingCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class CreateArchiveOutgoingCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "archive:outgoing";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create Archive Outgoing Mail";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
			$outgoings = OutgoingMailModel::isPublish()
						->isNotArchive()
						->get();
						
			if ($outgoings->isEmpty()) {
				$this->info("Specific Data Archive not found.");
				return;
			}
			
			foreach ($outgoings as $om) {
				$update = OutgoingMailModel::find($om->id);
				
				if ($update) {
					$update->update([
						'is_archive' => OutgoingMailStatusConstants::IS_ARCHIVE
					]);
					$this->info("Create Archive Outgoing Mail ID ". $om->id . " success");
				}
			}
			
			$this->info("Create Data Archive Outgoing Mail is Succesfully");
			
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}