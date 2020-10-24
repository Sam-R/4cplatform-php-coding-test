<?php

namespace Database\Factories;

use App\Models\Breed;
use Illuminate\Database\Eloquent\Factories\Factory;

class BreedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Breed::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $temperament = implode(
            ',',
            $this->faker->randomElements(
                [
                    'Active',
                    'Energetic',
                    'Independent',
                    'Intelligent',
                    'Gentle',
                    'Affectionate',
                    'Social',
                    'Playful',
                ],
                4
            )
        );

        return [
            'animal_type'       => $this->faker->randomElement(['dog', 'cat']),
            'name'              => $this->faker->word,
            'temperament'       => $temperament,
            'alternative_names' => implode(',', $this->faker->words(4)),
            'life_span'         => sprintf(
                '%d - %d',
                $this->faker->numberBetween(5, 15),
                $this->faker->numberBetween(16, 25)
            ),
            'origin'            => $this->faker->country,
            'wikipedia_url'     => $this->faker->url,
            'country_code'      => $this->faker->countryCode,
            'description'       => $this->faker->text(250),
            'favourite'         => $this->faker->boolean(50),
        ];
    }
}
