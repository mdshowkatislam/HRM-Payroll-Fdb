<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('serial')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('company')->nullable();
            $table->string('company_type')->nullable();
            $table->string('company_address')->nullable();
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
        Schema::dropIfExists('hrm_clients');
    }
}
