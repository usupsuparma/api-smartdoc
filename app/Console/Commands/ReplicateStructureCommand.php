<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;
use Exception;
use Illuminate\Console\Command;
use App\Modules\External\Users\Models\ExternalUserModel;
/**
 * Class createArchiveOutgoingCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ReplicateStructureCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "replicate:structure";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create Replicate Structure";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // try {
        //     $users = \DB::connection('bijb')->table('users')->get();
        //     $in_users = \DB::table('users')->get()->toArray();
        //     $no = 0;
        //     foreach ($users as $key => $us) {
        //         ExternalUserModel::create([
        //             'id_employee' => $us->id_employee,
        //             'email' => isset($in_users[$key]) ? $in_users[$key]->email : "email_{$key}@example.net",
        //             'kode_struktur' => $us->kode_struktur,
        //             'kode_jabatan' => $us->kode_jabatan,
        //             'status' => true,
        //         ]);
        //     }
			
		// 	$this->info("Create Data Replicate Structure is Succesfully");
			
        // } catch (Exception $e) {
        //     $this->error("An error occurred");
        // }
    }
}