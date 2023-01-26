<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_relation', function (Blueprint $table) {
            $table->id();
            $table->string('table_name_from');
            $table->string('field_from');
            $table->string('table_from_desc');
            $table->string('field_from_desc');
            $table->string('table_name_to');
            $table->string('refer_to');
            $table->string('table_to_desc');
            $table->string('refer_to_desc');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_relation');
    }
}
