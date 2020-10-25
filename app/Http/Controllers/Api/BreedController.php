<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchBreed;
use App\Http\Requests\Api\UpdateBreed;
use App\Http\Resources\BreedResource;
use App\Models\Breed;
use Config;
use Fcp\AnimalBreedsSearch\AnimalBreedsSearch;
// This includes constants for HTTP status codes.
use Illuminate\Http\Request;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request       $request request with animal_type, name or breed keys as filters
     * @return BreedResource
     */
    public function index(SearchBreed $request)
    {
        // There's inconsistency between the word doc and your postman collection;
        // doc says "name", postman says "breed",
        // I'll allow both in the filter method.
        $results = Breed::filter(
            $request->only('animal_type', 'name', 'breed')
        );

        if ($results->count() > 0) {
            return new BreedResource($results);
        }

        // The docs say if there are no results, query the 3rd party API,
        // personally I wouldn't do this live if I could help it.
        // For 3rd party APIs I tend to use queue workers to reduce request response time
        // data can be checked using crontab/scheduler, although I accept sometimes "live" is required.
        // In this case I'd probably implement an API Gateway like Kong because not really
        // any "application" here. I don't see much need to store things locally.
        $breed_api = new AnimalBreedsSearch(
            Config::get(
                sprintf(
                    'animal-breeds-search.services.the%sapi',
                    strtolower($request->input('animal_type'))
                )
            )
        );

        // TODO: from this point, this could all be refactored
        // TODO: Update this to be name or breed.
        $search_results = $breed_api->search($request->input('breed'));

        foreach ($search_results as $result) {
            $result['animal_type'] = strtolower($request->input('animal_type'));
            Breed::updateOrCreate(['remote_id' => $result['id']], $result);
        }

        // TODO: This needs DRYed up
        $results = Breed::filter(
            $request->only('animal_type', 'name', 'breed')
        );

        return new BreedResource($results);
    }

    /**
     * Display the specified resource.
     *
     * @param  Breed         $breed
     * @return BreedResource
     */
    public function show(Breed $breed)
    {
        return new BreedResource($breed);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBreed               $request
     * @param  Breed                     $breed
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBreed $request, Breed $breed)
    {
        $breed->update($request->validated());

        return new BreedResource($breed);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Breed                     $breed Breed resource.
     * @throws \Exception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Breed $breed)
    {
        $breed->delete();

        return response(['message' => 'resource deleted']);
    }
}
