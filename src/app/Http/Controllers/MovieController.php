<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\MovieFormRequest;
use App\Contracts\MovieApiServiceInterface;

/**
 * @group Movies
 *
 * API for managing movies.
 */
class MovieController extends Controller
{
    public function __construct(
        private readonly MovieApiServiceInterface $movieApiService
    ) {}

    /**
     * Get all movies
     *
     * Returns a list of all movies.
     *
     * @queryParam title string Search by title. Example: Inception
     * 
     * @response 200 {
     *    "success": true,
     *    "data": [
     *        {
     *            "id": 1,
     *            "title": "Inception",
     *            "age_rating": 16,
     *            "language": "English",
     *            "cover_image": "https://example.com/inception.jpg",
     *            "projections": [
     *                {
     *                    "id": 1,
     *                    "start_time": "2025-03-25 19:00:00",
     *                    "available_seats": 100
     *                },
     *                {
     *                    "id": 2,
     *                    "start_time": "2025-03-26 14:00:00",
     *                    "available_seats": 150
     *                }
     *            ]
     *        },
     *        {
     *            "id": 2,
     *            "title": "Titanic",
     *            "age_rating": 12,
     *            "language": "English",
     *            "cover_image": "https://example.com/titanic.jpg",
     *            "projections": [
     *                {
     *                    "id": 3,
     *                    "start_time": "2025-03-28 20:00:00",
     *                    "available_seats": 200
     *                }
     *            ]
     *        }
     *    ]
     * }
     */
    public function index()
    {
        return response()->json($this->movieApiService->getMovies());
    }

    /**
     * Create a new movie
     *
     * @bodyParam title string required The title of the movie. Example: Inception
     * @bodyParam age_rating integer required The age rating of the movie. Example: 16
     * @bodyParam language string required The language of the movie. Example: English
     * @bodyParam cover_image string The cover image URL of the movie. Example: https://example.com/inception.jpg
     *
     * @response 201 {
     *    "success": true,
     *    "id": 1
     * }
     *
     * @response 422 {
     *    "message": "Validation Error",
     *    "errors": {
     *        "title": ["The title field is required."],
     *        "age_rating": ["The age_rating field is required."]
     *    }
     * }
     */
    public function store(MovieFormRequest $request)
    {
        $validatedData = $request->validated();

        $movie = $this->movieApiService->createMovie($validatedData);

        if ($movie) {
            return $this->response(['success' => true, 'id' => $movie], 201);
        }

        return $this->response([
            'success' => false,
            'message' => 'Failed to create movie',
        ], 500);
    }

    /**
     * Get a single movie
     *
     * Returns a single movie by ID.
     *
     * @urlParam id integer required The ID of the movie. Example: 1
     *
     * @response 200 {
     *    "success": true,
     *    "data": {
     *        "id": 1,
     *        "title": "Inception",
     *        "age_rating": 16,
     *        "language": "English",
     *        "cover_image": "https://example.com/inception.jpg"
     *    }
     * }
     *
     * @response 404 {
     *    "success": false,
     *    "message": "Movie not found"
     * }
     */
    public function show(string $id)
    {
        return $this->response($this->movieApiService->getMovieById($id));
    }

    /**
     * Update a movie
     *
     * Updates an existing movie.
     *
     * @urlParam id integer required The ID of the movie. Example: 1
     * 
     * @bodyParam title string The title of the movie. Example: Inception
     * @bodyParam age_rating integer The age rating of the movie. Example: 16
     * @bodyParam language string The language of the movie. Example: English
     * @bodyParam cover_image string The cover image URL of the movie. Example: https://example.com/inception.jpg
     *
     * @response 200 {
     *    "success": true,
     *    "id": 1
     * }
     *
     * @response 404 {
     *    "success": false,
     *    "message": "Movie not found"
     * }
     */
    public function update(Request $request, string $id)
    {
        $movie = $this->movieApiService->updateMovie($id, $request);

        if (!$movie) {
            return $this->response(['success' => false, 'message' => 'Movie not found'], 404);
        }

        return $this->response(['success' => true, 'id' => $movie]);
    }

    /**
     * Delete a movie
     *
     * Deletes a movie by ID.
     *
     * @urlParam id integer required The ID of the movie. Example: 1
     *
     * @response 200 {
     *    "success": true,
     *    "message": "Movie deleted successfully"
     * }
     *
     * @response 404 {
     *    "success": false,
     *    "message": "Movie not found"
     * }
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
