<?php

use Illuminate\Database\Seeder;
use App\Modules\MappingStructure\Models\MappingStructureModel;

class MappingStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MappingStructureModel::create([
            'code' => 'MS001',
            'name' => 'Direktur'
        ]);
        
        MappingStructureModel::create([
            'code' => 'MS002',
            'name' => 'Direksi'
        ]);
        
        MappingStructureModel::create([
            'code' => 'MS003',
            'name' => 'VP'
        ]);
        
        MappingStructureModel::create([
            'code' => 'MS004',
            'name' => 'Department'
        ]);
        
    }
}
