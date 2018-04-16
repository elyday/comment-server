<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("comments", function (Blueprint $table) {
            $table->string("hash", 50);
            $table->primary("hash");
            $table->string("articleHash", 50);
            $table->string("authorName");
            $table->string("authorMail")->nullable();
            $table->string("title")->nullable();
            $table->string("content");
            $table->timestamps();
            $table->foreign("articleHash")->references("hash")->on("blog_article");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("comments");
    }
}
