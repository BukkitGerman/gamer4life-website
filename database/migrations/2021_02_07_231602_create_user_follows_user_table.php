<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFollowsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usersTable = config('acl.tables.users', 'users');
        Schema::create('user_follows_user', 
        function (Blueprint $table) use ($usersTable) {
            $table->bigInteger('user_id', false, true);
            $table->bigInteger('follower_id', false, true);
            $table->foreign('user_id')
                    ->references('id')
                    ->on($usersTable)
                    ->onDelete('cascade');
            $table->foreign('follower_id')
                    ->references('id')
                    ->on($usersTable)
                    ->onDelete('cascade');
            $table->primary(['user_id', 'follower_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follows_user');
    }
}
