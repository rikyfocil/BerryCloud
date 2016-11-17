<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('isVirtual')->default(false);
        });

         Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('idOwner')->unsigned();
            $table->integer('idGenerated')->unsigned();
            

            $table->foreign('idOwner')
                ->references('id')->on('users')
                ->onDelete('cascade');
            
            $table->foreign('idGenerated')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('idGroup')->unsigned();
            $table->integer('idMember')->unsigned();
            

            $table->foreign('idGroup')
                ->references('id')->on('groups')
                ->onDelete('cascade');
            
            $table->foreign('idMember')
                ->references('id')->on('users')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('isVirtual');
        });

        Schema::drop('members');
        Schema::drop('groups');

    }
}
