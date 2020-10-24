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
            // I'd probably split this into it's own table and foreign key it in "real world".
            $table->string('animal_type');
            // Your docs seem to suggest this can be nullable 🤨, I'd probably make it a key/index.
            // if it can be unique and we're using "name" to search for breeds it'd be much faster indexed.
            $table->string('name')->nullable();
            // I'd probably split this into it's own table and foreign key it in "real world".
            $table->string('temperament');
            // I'm KISSing but this could be a "pigs ear" relationship
            // or broken into it's own table of searchable strings.
            $table->string('alternative_names')->nullable();
            // This could be broken int estimated_min and estimated_max lifespan.
            // I feel like this would make it more searchable instead of having to interrogate a string in SQL.
            $table->string('life_span')->nullable();
            // Origin and country_code could both be broken into a "countries" table.
            $table->string('origin')->nullable();
            $table->string('wikipedia_url')->nullable();
            // I'm going with what I'd use, ISO 3166-1 2 digit country codes
            // Your postman example uses language code "en_GB" 🤨 why?
            $table->string('country_code', 2)->nullable();
            $table->text('description')->nullable();
            // This probably should be "Favorite by user" but your docs don't seem to suggest this is the case?
            // At least I can't find explicit instruction that it should to be that way.
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
