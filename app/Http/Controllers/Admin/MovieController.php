<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies', compact('movies'));
    }

    public function create()
    {
        return view('admin.movie-create');
    }

    public function store(MovieRequest $request)
    {
        $data = $request->except('_token');

        $smallThumbnail = $request->small_thumbnail;
        $largeThumbnail = $request->large_thumbnail;

        $originalSmallThumbnailName = Str::random(10).$smallThumbnail->getClientOriginalName();
        $originalLargeThumbnailName = Str::random(10).$largeThumbnail->getClientOriginalName();

        $smallThumbnail->storeAs('public/thumbnail', $originalSmallThumbnailName);
        $largeThumbnail->storeAs('public/thumbnail', $originalLargeThumbnailName);

        $data['small_thumbnail'] = $originalSmallThumbnailName;
        $data['large_thumbnail'] = $originalLargeThumbnailName;

        Movie::create($data);

        return redirect()->route('admin-movie')->with('success', 'Movie Created!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movie-edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        $request->validate([
            'title' => 'required|string',
            'small_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'large_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'casts' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required',
        ]);

        $movie = Movie::find($id);

        if ($request->small_thumbnail){
            //Save new image
            $smallThumbnail = $request->small_thumbnail;
            $originalSmallThumbnailName = Str::random(10).$smallThumbnail->getClientOriginalName();
            $smallThumbnail->storeAs('public/thumbnail', $originalSmallThumbnailName);
            $data['small_thumbnail'] = $originalSmallThumbnailName;

            //delete old image
            Storage::delete('public/thumbnail/'.$movie->small_thumbnail);
        }

        if ($request->large_thumbnail){
            //Save new image
            $largeThumbnail = $request->large_thumbnail;
            $originalLargeThumbnailName = Str::random(10).$largeThumbnail->getClientOriginalName();
            $largeThumbnail->storeAs('public/thumbnail', $originalLargeThumbnailName);
            $data['large_thumbnail'] = $originalLargeThumbnailName;

            //delete old image
            Storage::delete('public/thumbnail/'.$movie->large_thumbnail);
        }

        $movie->update($data);

        return redirect()->route('admin-movie')->with('success', 'Movie Updated!');
    }

    public function destroy($id)
    {
        Movie::find($id)->delete();
        return redirect()->route('admin-movie')->with('success', 'Movie Deleted!');
    }
}
