<?php

use Illuminate\Database\Migrations\Migration;
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
        Schema::create('posts', function (Chewbathra\Chewby\Database\Blueprint $table) {
            $table->neededColumns();
            $table->softDeletes();
            $table->wysiwyg('description')->nullable(true)->default(null);
            $table->editor('editor');
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
