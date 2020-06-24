<?php

use Illuminate\Database\Seeder;

class Departmen extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departmens')->insert([
	        'nama'  => 'Umum/Semua'
		]);

		DB::table('departmens')->insert([
	        'nama'  => 'Divisi Pengkaderan'
		]);

		DB::table('departmens')->insert([
	        'nama'  => 'Divisi Humas'
		]);

		DB::table('departmens')->insert([
	        'nama'  => 'Divisi Ilmu Pengetahuan dan Teknologi'
		]);

		DB::table('departmens')->insert([
	        'nama'  => 'Divisi Kesekretariatan'
		]);
    }
}
