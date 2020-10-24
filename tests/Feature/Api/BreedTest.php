<?php

namespace Tests\Feature\Api;

use App\Models\Breed;
use Tests\TestCase;

class BreedTest extends TestCase
{
    /**
     * Test API requests to /api/breeds return the appropriate JSON structure.
     *
     * @return void
     */
    public function testBreedsCanBeLoadedFromDatabase(): void
    {
        Breed::factory(5)->create();

        $response = $this->get('/api/breeds');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'animal_type',
                    'name',
                    'temperament',
                    'alternative_names',
                    'life_span',
                    'origin',
                    'wikipedia_url',
                    'country_code',
                    'description',
                    'favourite',
                    'created_at',
                    'updated_at',
                ]]
            ]);
    }

    /**
     * Test API requests to GET /api/breed/{id} return the appropriate JSON structure.
     *
     * @return void
     */
    public function testABreedCanBeLoadedFromDatabase(): void
    {
        Breed::factory(5)->create();

        $selected_breed = Breed::all()->random();

        $response = $this->get(
            sprintf(
                '/api/breeds/%d',
                $selected_breed->id
            )
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'animal_type',
                    'name',
                    'temperament',
                    'alternative_names',
                    'life_span',
                    'origin',
                    'wikipedia_url',
                    'country_code',
                    'description',
                    'favourite',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJson([
                'data' => [
                    'id' => $selected_breed->id
                ]
            ]);
    }

    /**
     * Test API requests to PUT /api/breed/{id} updates the DB and returns the appropriate JSON structure.
     *
     * @return void
     */
    public function testABreedCanBeUpdated(): void
    {
        Breed::factory(5)->create();
        $updated_breed = Breed::factory()->make()->toArray();

        $selected_breed = Breed::all()->random();

        $response = $this->putJson(
            sprintf(
                '/api/breeds/%d',
                $selected_breed->id
            ),
            $updated_breed
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'animal_type',
                    'name',
                    'temperament',
                    'alternative_names',
                    'life_span',
                    'origin',
                    'wikipedia_url',
                    'country_code',
                    'description',
                    'favourite',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJson([
                'data' => [
                    'id' => $selected_breed->id
                ]
            ]);
    }
}
