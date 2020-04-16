<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {

            # Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column.
            $table->bigIncrements('id');

            # Adds nullable created_at and updated_at TIMESTAMP equivalent columns with precision (total digits).
            $table->timestamps();

            // slug VARCHAR
            $table->string('slug');

            // title VARCHAR
            $table->string('title');

            // author VARCHAR
            # No longer need this column, because we are now using an author_id FK
            // $table->string('author');

            // published_year SMALLINT
            $table->smallInteger('published_year');

            // cover_url VARCHAR
            $table->string('cover_url');

            // info_url VARCHAR
            $table->string('info_url');

            // purchase_url VARCHAR
            $table->string('purchase_url');

            // description TEXT
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
