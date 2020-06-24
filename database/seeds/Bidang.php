<?php

use Illuminate\Database\Seeder;

class Bidang extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bidangs')->insert([
	        'nama'  => 'Umum/Semua'
		]);

		DB::table('bidangs')->insert([
	        'nama'  => 'Divisi Pengkaderan'
		]);

		DB::table('bidangs')->insert([
	        'nama'  => 'Divisi Humas'
		]);

		DB::table('bidangs')->insert([
	        'nama'  => 'Divisi Ilmu Pengetahuan dan Teknologi'
		]);

		DB::table('bidangs')->insert([
	        'nama'  => 'Divisi Kesekretariatan'
		]);
    }
}
