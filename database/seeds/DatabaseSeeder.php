<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(BackdoorSeeder::class);
        // $this->call(TestSeeder::class);
        // $this->call(EmployeeSeeder::class);
        
        if (\DB::table('menus')->count() === 0) {
            $this->call(MenusTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(MenuRolesTableSeeder::class);
            $this->call(SettingsTableSeeder::class);
            $this->call(TemplatesTableSeeder::class);
            $this->call(TypesTableSeeder::class);
            $this->call(ReviewsTableSeeder::class);
            $this->call(ClassificationTableSeeder::class);
            $this->call(ClassDispositionTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(MappingStructureTableSeeder::class);
        }
    }
}
