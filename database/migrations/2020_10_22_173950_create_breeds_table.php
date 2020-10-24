<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            // Validate to dog or cat.
            $table->string('animal_type');
            $table->string('name');
            // Could be a foreign key.
            $table->string('temperament');
            $table->string('alternative_names')->nullable();
            $table->string('life_span');
            $table->string('origin');
            $table->string('wikipedia_url');
            $table->string('country_code', 2);
            $table->text('description');
            $table->boolean('favourite')->default(false);
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
        Schema::dropIfExists('breeds');
    }
}
