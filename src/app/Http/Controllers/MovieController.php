<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\MovieFormRequest;
use App\Contracts\MovieApiServiceInterface;
use Illuminate\Support\Js;

class MovieController extends Controller
{
    public function __construct(
        private readonly MovieApiServiceInterface $movieApiService
        )    
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->movieApiService->getMovies());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieFormRequest $request)
    {
        $validatedData = $request->validated();

        $movie = $this->movieApiService->createMovie($validatedData);

        if ($movie) {
            return $this->response(['success' => true, 'id' => $movie ] , 201);
        }

        return $this->response([
            'success' => false,
            'message' => 'Failed to create movie',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->response($this->movieApiService->getMovieById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movie = $this->movieApiService->updateMovie($id, $request);

        if (!$movie) {
            return $this->response(['success' => false, 'message' => 'Movie not found' ], 404);
        }

        return $this->response(['success' => true, 'id' => $movie]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return $this->response([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        $movie->delete();

        return $this->response([
            'success' => true,
            'message' => 'Movie deleted successfully',
        ]);
    }
}
