<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->onDelete('cascade');
            $table->foreignId('sub_subcategory_id')->nullable()->constrained('sub_sub_categories')->onDelete('cascade');
            $table->string('episode')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->string('image')->nullable();
            $table->string('video_public_id')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_status')->nullable();
            $table->foreignId('admin_id');
            $table->integer('view_count')->default(0);
            $table->tinyInteger('active_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
