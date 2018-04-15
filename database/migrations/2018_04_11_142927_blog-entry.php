<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BlogEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("blog_article", function (Blueprint $table) {
            $table->integer("id", true);
            $table->integer("blogId");
            $table->string("title");
            $table->string("author");
            $table->string("url");
            $table->timestamps();
        });
        Schema::table("blog_article", function (Blueprint $table) {
            $table->foreign("blogId")->references("id")->on("blog");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("blog_article");
    }
}
