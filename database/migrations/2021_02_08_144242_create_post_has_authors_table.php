<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostHasAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $usersTable = config('acl.tables.users', 'users');
        $postsTable = config('posts', 'posts');
        Schema::create('post_has_authors',
            function (Blueprint $table) use ($usersTable, $postsTable) {
                $table->bigInteger('user_id', false, true);
                $table->bigInteger('post_id', false, true);
                $table->foreign('user_id')
                    ->references('id')
                    ->on($usersTable)
                    ->onDelete('cascade');
                $table->foreign('post_id')
                    ->references('id')
                    ->on($postsTable)
                    ->onDelete('cascade');
                $table->primary(['user_id', 'post_id']);
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
        Schema::dropIfExists('post_has_authors');
    }
}
