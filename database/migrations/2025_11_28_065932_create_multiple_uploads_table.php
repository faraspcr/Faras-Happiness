<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('multipleuploads', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('original_name');
            $table->string('ref_table', 100);
            $table->unsignedBigInteger('ref_id');
            $table->timestamps();


            $table->index(['ref_table', 'ref_id']);
        });
    }


    public function down()
    {
        Schema::dropIfExists('multipleuploads');
    }
};



