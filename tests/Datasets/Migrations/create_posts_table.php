<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the Migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable(false);
            $table->boolean('online')->nullable(false)->default(false);
            $table->dateTime('online_from')->nullable(true)->default(null);
            $table->dateTime('online_until')->nullable(true)->default(null);
            $table->json('content')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the Migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
