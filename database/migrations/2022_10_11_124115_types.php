<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chewby_types', function (Blueprint $table) {
            $table->string('tableName')->nullable(false);
            $table->string('columnName')->nullable(false);
            $table->string('columnType')->nullable(false);

            $table->primary(['tableName', 'columnName']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chewby_types');
    }
};
