<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalkthroughsTable extends Migration
{
    public function up()
    {
        Schema::create('walkthroughs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('page')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
