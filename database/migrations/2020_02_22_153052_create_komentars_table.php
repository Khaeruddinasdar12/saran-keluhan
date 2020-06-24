<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('nohp')->nullable();
            $table->string('alamat')->nullable();
            $table->enum('admin_verified', ['yes', 'no']);
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('pesan');
            $table->bigInteger('bidang_id')->unsigned();
            $table->timestamps();
            $table->foreign('bidang_id')->references('id')->on('bidangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komentars');
    }
}
