<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangelogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usersTable = config('acl.tables.users', 'users');
        Schema::create('changelogs', 
            function (Blueprint $table) use ($usersTable){
                $table->id();
                $table->string('title');
                $table->text('body');
                $table->date('date');
                $table->bigInteger('author', false, true);
                $table->foreign('author')
                    ->references('id')
                    ->on($usersTable)
                    ->onDelete('cascade');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('changelogs');
    }
}
