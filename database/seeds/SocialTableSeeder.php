<?php
use Illuminate\Database\Seeder;

class SocialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social')->delete();

        DB::table('social')->insert([
            'id' => 1,
            'name' => 'Facebook',
            'status' => 1,
        ]);
        DB::table('social')->insert([
            'id' => 2,
            'name' => 'Zalo',
            'status' => 0,
        ]);
        DB::table('social')->insert([
            'id' => 3,
            'name' => 'Twitter',
            'status' => 0,
        ]);
    }
}