<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $movies = Movie::all();
        return response()->json($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'release_date' => 'required|date',
        'genre_id' => 'required|exists:genres,id',
        'rating' => 'required|numeric|min:0|max:10',
        'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Remove the image fields from validated data
    $movieData = collect($validated)
        ->except(['poster_image', 'image_banner'])
        ->toArray();

    // Handle poster image
    if ($request->hasFile('poster_image')) {
        $posterImagePath = $request->file('poster_image')->store('images', 'public');
        $movieData['poster_image'] = $posterImagePath;
    }
    
    // Handle banner image
    if ($request->hasFile('image_banner')) {
        $imageBannerPath = $request->file('image_banner')->store('images', 'public');
        $movieData['image_banner'] = $imageBannerPath;
    }

    // Create the movie with all data including image paths
    $movie = Movie::create($movieData);

    return redirect()->route('movies.index')->with('success', 'Movie created successfully!');
}

    /**
     * Display the specified resource.
     *
     * @param  Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Movie $movie)
{
    $movie->load(['shows' => function ($query) {
        $query->with(['screen', 'screen.theater']); 
    }]);

    // Optional: Include available seats for each show 
    $movie->shows->each(function ($show) {
        $show->available_seats = $show->screen->seats()->whereDoesntHave('bookings')->get(); 
    });

    return response()->json($movie);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'genre_id' => 'required|exists:genres,id',
            'rating' => 'required|numeric|min:0|max:10',
            'poster_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('poster_image')) {
            // Store the image in the 'images' directory inside the 'public' disk
            $posterImagePath = $request->file('poster_image')->store('images', 'public');
            $movie->poster_image = $posterImagePath;
            $movie->save(); // Save the relative path in the database
        }
        
        if ($request->hasFile('image_banner')) {
            // Store the image in the 'images' directory inside the 'public' disk
            $imageBannerPath = $request->file('image_banner')->store('images', 'public');
            $movie->image_banner = $imageBannerPath;
            $movie->save(); // Save the relative path in the database
        }

        $movie->update($validated);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Movie  $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully!']);
    }
}
