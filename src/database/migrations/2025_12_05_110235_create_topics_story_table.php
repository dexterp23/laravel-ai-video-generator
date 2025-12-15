<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics_story', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('viral_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('hashtags')->nullable();
            $table->json('script')->nullable();
            $table->string('video_title')->nullable();
            $table->integer('video_status')->default(0);
            $table->string('video_id')->nullable();
            $table->string('video_ai_client')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('topics_story', function (Blueprint $table) {
            $table->foreign('viral_id')
                ->references('id')
                ->on('topics_viral')
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
        Schema::dropIfExists('topics_story');
    }
}
