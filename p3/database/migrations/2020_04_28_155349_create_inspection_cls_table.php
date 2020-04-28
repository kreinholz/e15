<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionClsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_cls', function (Blueprint $table) {
            # Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->id();

            # Adds nullable created_at and updated_at TIMESTAMP equivalent columns with precision (total digits)
            $table->timestamps();

            # Add a title for this particular checklist, e.g. "Checklist for Reviewing the Rail Transit Agency Safety Plan"
            $table->string('title');

            # Instantiate an unsigned new column to act as a foreign key
            # See https://github.com/susanBuck/e15-spring20/issues/38
            $table->bigInteger('inspector_id')->unsigned();
            
            # Inspector FOREIGN KEY from users table
            $table->foreign('inspector_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspection_cls');
    }
}
