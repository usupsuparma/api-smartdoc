<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Modules\MappingStructure\Models\MappingStructureModel;
use App\Modules\Review\Models\ReviewModel;
class AddRowReviewDirector extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ReviewModel::create([
            'code' => 'OMD',
            'name' => 'Approval Surat Keluar Level Direktur',
            'status' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
