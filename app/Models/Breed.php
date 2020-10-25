<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_type',
        'favorite',
        'breed',
        'name',
        'temperament',
        'life_span',
        'origin',
        'wikipedia_url',
        'country_code',
        'description',
        'remote_id',
    ];

    protected $hidden = [
        'remote_id'
    ];

    /**
     * Query and return filtered results from breeds table
     * @param array $filters Key-value pairs of fields to search.
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
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
                throw new Exception('Unknown filter key provided', 1);
            }
        }

        return $breeds->get();
    }
}
