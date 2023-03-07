<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\UserPremium;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function show($id)
    {
        $movie = Movie::find($id);

        return view('member.movie-detail', compact('movie'));
    }

    public function watch($id)
    {
        $userId = auth()->user()->id;

        $userPremium = UserPremium::where('user_id', $userId)->first();

        if ($userPremium) {
            $endOfSubscription = $userPremium->end_of_subscription;
            $date = Carbon::createFromFormat('Y-m-d', $endOfSubscription);
            $isValid = $date->greaterThan(now());

            if ($isValid){
                $movie = Movie::find($id);
                return view('member.movie-watching', compact('movie'));
            }
        }
        return redirect()->route('pricing');
    }
}
