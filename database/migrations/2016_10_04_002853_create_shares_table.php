<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('idFile')->unsigned();
            $table->integer('idUser')->unsigned();
            $table->integer('idPermissionType')->unsigned();
            $table->date('dueDate')->nullable();

            $table->foreign('idFile')
                ->references('id')->on('files')
                ->onDelete('cascade');

            $table->foreign('idUser')
                ->references('id')->on('users')
                ->onDelete('cascade');
            
            $table->foreign('idPermissionType')
                ->references('id')->on('permission_types')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shares');
    }
}
