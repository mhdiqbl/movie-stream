<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use Illuminate\Http\Request;

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
    }
}
