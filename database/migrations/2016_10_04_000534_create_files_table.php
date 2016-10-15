<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
<<<<<<< HEAD
            $table->string('name');
=======
>>>>>>> b1af922ae2ea4503db11d7374397e24d4ba50104
            $table->integer('owner')->unsigned();
            $table->integer('parent')->unsigned()->nullable();
            $table->boolean('isFolder')->default(false);
            $table->boolean('publicRead')->default(false);

            $table->foreign('owner')
                ->references('id')->on('users')
                ->onDelete('cascade');
            
            $table->foreign('parent')
                ->references('id')->on('files')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
