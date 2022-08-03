<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger("views_number")->default(0);
            $table->unsignedInteger("comments_number")->default(0);
            $table->unsignedInteger("likes_number")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('views_number');
            $table->dropColumn('likes_number');
            $table->dropColumn('comments_number');
        });
    }
}
