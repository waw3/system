<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxEmailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox_emails', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('from');
            $table->string('subject');
            $table->text('body');
            $table->smallInteger('read')->nullable();
            $table->smallInteger('starred')->nullable();
            $table->smallInteger('sent')->nullable();
            $table->smallInteger('bookmarked')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('inbox');
    }
}
