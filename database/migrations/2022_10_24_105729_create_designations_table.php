<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hrm_client_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('parent_designation_id')->default(0);
            $table->bigInteger('serial')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('designations');
    }
}
