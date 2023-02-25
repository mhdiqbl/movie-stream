<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    public function index()
    {
        return view('admin.movies');
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
}
