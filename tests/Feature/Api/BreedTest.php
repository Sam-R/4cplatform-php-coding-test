<?php

namespace Tests\Feature\Api;

use App\Models\Breed;
use App\Models\User;
use Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BreedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    /**
     * Test API requests to /api/breeds return the appropriate JSON structure.
     *
     * @return void
     */
    public function testBreedsCanBeLoadedFromDatabase(): void
    {
        Breed::factory(5)->create();

        $breed = Breed::all()->random();

        $response = $this->json(
            'GET',
            '/api/breeds',
            [
                'animal_type' => $breed->animal_type,
                'name'        => $breed->name
            ]
        );

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
     * Test API requests to /api/breeds?filter return the appropriate response
     *
     * @return void
     */
    public function testBreedsCanBeFilteredFromDatabase(): void
    {
        // This isn't as "random" as I'd like, but in the interest of speed...
        $unselected_breed = Breed::factory()->create([
            'animal_type' => 'dog',
            'name'        => 'test breed',
        ]);

        $selected_breed = Breed::factory()->create([
            'animal_type' => 'cat',
            'name'        => 'test breed',
        ]);

        $response = $this->json(
            'GET',
            '/api/breeds',
            [
                'animal_type' => 'cat',
                'name'        => $selected_breed->name
            ]
        );

        $response->assertStatus(200)
            ->assertJson([
                'data' => [[
                    'id' => $selected_breed->id
                ]]
            ])
            ->assertJsonMissing([
                'data' => [
                    'id' => $unselected_breed->id
                ]
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

    /**
     * Test API requests to PUT /api/breed/{id} updates the DB and returns the appropriate JSON structure.
     *
     * @return void
     */
    public function testABreedCanBeDeleted(): void
    {
        Breed::factory(5)->create();
        $breed_to_delete = Breed::all()->random();

        $response = $this->deleteJson(
            sprintf(
                '/api/breeds/%d',
                $breed_to_delete->id
            )
        );

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'resource deleted'
            ]);
        $this->assertDatabaseMissing('breeds', ['id' => $breed_to_delete->id]);
    }

    /**
     * Test the filter method throws an exception if an invalid key is provided
     * @throws \Exception
     */
    public function testBreedFilterRejectsUnknownKeys()
    {
        $this->expectException(\Exception::class);
        Breed::filter(['fake_key' => 'value']);
    }

    /**
     * Test API requests to /api/breeds return the appropriate JSON structure.
     *
     * @return void
     */
    public function testBreedsCanBeLoadedFromApi(): void
    {
        $breed = Breed::factory()->make(['name' => 'British Shorthair']);

        Http::fake([
            // Stub a JSON response for GitHub endpoints...
            '*' => Http::response([
                [
                    'adaptability'      => 5,
                    'affection_level'   => 4,
                    'alt_names'         => 'Highlander, Highland Straight, Britannica',
                    'cfa_url'           => 'http://cfa.org/Breeds/BreedsAB/BritishShorthair.aspx',
                    'child_friendly'    => 4,
                    'country_code'      => 'GB',
                    'country_codes'     => 'GB',
                    'description'       => 'The British Shorthair is a very pleasant cat to have as a companion.',
                    'dog_friendly'      => 5,
                    'energy_level'      => 2,
                    'experimental'      => 0,
                    'grooming'          => 2,
                    'hairless'          => 0,
                    'health_issues'     => 2,
                    'hypoallergenic'    => 0,
                    'id'                => 'bsho',
                    'indoor'            => 0,
                    'intelligence'      => 3,
                    'lap'               => 1,
                    'life_span'         => '12 - 17',
                    'name'              => 'British Shorthair',
                    'natural'           => 1,
                    'origin'            => 'United Kingdom',
                    'rare'              => 0,
                    'rex'               => 0,
                    'shedding_level'    => 4,
                    'short_legs'        => 0,
                    'social_needs'      => 3,
                    'stranger_friendly' => 2,
                    'suppressed_tail'   => 0,
                    'temperament'       => 'Affectionate, Easy Going, Gentle, Loyal, Patient, calm',
                    'vcahospitals_url'  => 'https://vcahospitals.com/know-your-pet/cat-breeds/british-shorthair',
                    'vetstreet_url'     => 'http://www.vetstreet.com/cats/british-shorthair',
                    'vocalisation'      => 1,
                    'weight'            => [
                        'imperial' => '12 - 20',
                        'metric'   => '5 - 9'
                    ],
                    'wikipedia_url' => 'https://en.wikipedia.org/wiki/British_Shorthair'
                ]
            ], 200)
        ]);

        $response = $this->json(
            'GET',
            '/api/breeds',
            [
                'animal_type' => $breed->animal_type,
                'breed'        => $breed->name
            ]
        );

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

    //TODO => Test for breeds not found in the system or 3rd party API.
}
