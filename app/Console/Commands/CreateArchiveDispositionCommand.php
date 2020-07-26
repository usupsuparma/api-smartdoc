<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Modules\Disposition\Models\DispositionModel;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use Exception;
use Illuminate\Console\Command;

/**
 * Class createArchiveDispositionCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class CreateArchiveDispositionCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "archive:disposition";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create Archive Disposition Mail";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
			$dispositions = DispositionModel::isDone()
						->isNotArchive()
						->get();
						
			if ($dispositions->isEmpty()) {
				$this->info("Specific Data Archive not found.");
				return;
			}
			
			foreach ($dispositions as $om) {
				$update = DispositionModel::find($om->id);
				
				if ($update) {
					$update->update([
						'is_archive' => IncomingMailStatusConstans::IS_ARCHIVE
					]);
					$this->info("Create Archive Disposition Mail ID ". $om->id . " success");
				}
			}
			
			$this->info("Create Data Archive Disposition Mail is Succesfully");
			
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}