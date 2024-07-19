<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKotaksaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kotaksaran', function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("email");
            $table->string("no_telepon");
            $table->unsignedBigInteger("kategori_id");
            $table->unsignedBigInteger("penempatan_id");
            $table->text("saran");
            $table->string("foto");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kotaksaran');
    }
}
