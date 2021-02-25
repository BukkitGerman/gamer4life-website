<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeadTopicHasTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $topicTable = config('topics', 'topics');
        $HeadTopicTable = config('head_topics', 'head_topics');
        Schema::create('head_topic_has_topics', 
            function (Blueprint $table) use ($topicTable, $HeadTopicTable){
                $table->bigInteger('head_topic_id', false, true);
                $table->bigInteger('topic_id', false, true);
                $table->foreign('head_topic_id')
                    ->references('id')
                    ->on($HeadTopicTable)
                    ->onDelete('cascade');
                $table->foreign('topic_id')
                    ->references('id')
                    ->on($topicTable)
                    ->onDelete('cascade');
                $table->primary(['head_topic_id', 'topic_id']);
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
        Schema::dropIfExists('head_topic_has_topics');
    }
}
