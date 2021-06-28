<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // blog table
        $topicTable = config('topics', 'topics');
        Schema::create('posts', 
            function (Blueprint $table) use ($topicTable){
                $table->id();
                $table->string('title')->unique();
                $table->text('body');
                $table->bigInteger('topic', false, true);
                $table->foreign('topic')
                ->references('id')->on($topicTable)
                ->onDelete('cascade');
                $table->string('slug')->unique();
                $table->boolean('active');
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
        Schema::dropIfExists('posts');
    }
}
