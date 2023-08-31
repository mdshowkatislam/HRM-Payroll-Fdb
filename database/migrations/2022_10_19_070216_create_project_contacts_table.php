<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('designation')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_contacts');
    }
}
