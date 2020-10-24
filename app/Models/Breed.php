<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_type',
        'favorite',
        'breed',
        'temperament',
        'life_span',
        'origin',
        'wikipedia_url',
        'country_code',
        'description',
    ];

    public static function filter(array $filters)
    {
        $breeds = self::query();
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'name':
                case 'breed':
                    $breeds->where('name', 'like', sprintf('%%%s%%', $value));
                break;

                case 'animal_type':
                    $breeds->where('animal_type', $value);
                break;

                default:
                    // In some situations I'd be logging what got through validation.
                break;
            }
        }

        return $breeds->get();
    }
}
