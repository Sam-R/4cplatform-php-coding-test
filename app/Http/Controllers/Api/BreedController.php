<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateBreed;
use App\Http\Resources\BreedResource;
use App\Models\Breed;
use Illuminate\Http\Request;
// This includes constants for HTTP status codes.
use Symfony\Component\HttpFoundation\Response as IlluminateRepsonse;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request request with animal_type, name or breed keys as filters
     * @return BreedResource
     */
    public function index(Request $request)
    {
        // There's inconsistency between the word doc and your postman collection here.
        // doc says "name", postman says "breed". I'll allow both.
        $results = Breed::filter(
            $request->only('animal_type', 'name', 'breed')
        );

        // if no results, call 3rd party API
        return new BreedResource($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response([], IlluminateRepsonse::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response([], IlluminateRepsonse::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Breed $breed
     * @return BreedResource
     */
    public function show(Breed $breed)
    {
        return new BreedResource($breed);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response([], IlluminateRepsonse::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBreed $request
     * @param Breed $breed
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
     * @param  int                       $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response([], IlluminateRepsonse::HTTP_NOT_IMPLEMENTED);
    }
}
