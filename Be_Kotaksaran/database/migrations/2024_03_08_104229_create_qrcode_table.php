<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQRCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrcode', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('penempatan_id');
            $table->string('qr_code_value');
            $table->string('qr_code_image')->nullable();
            $table->timestamps();
        });

        Schema::table('qrcode', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('penempatan_id')->references('id')->on('penempatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qrcode', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['penempatan_id']);
        });
        
        Schema::dropIfExists('qrcode');
    }
}