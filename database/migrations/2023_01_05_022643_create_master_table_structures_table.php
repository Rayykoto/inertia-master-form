<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTableStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_table_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id');
            $table->string('field_name');
            $table->string('field_description');
            $table->string('is_show',1);
            $table->string('data_type');
            $table->string('relation',1);
            $table->text('relate_to')->nullable();
            $table->string('input_type');
            $table->timestamps();
            $table->string('created_by');

            $table->foreign('table_id')->references('id')->on('master_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_table_structures');
    }
}
