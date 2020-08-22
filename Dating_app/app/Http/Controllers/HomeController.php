<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TempData;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $circle_radius = 11000;
        $max_distance = 5;
        $lat = 23.7549;
        $lng = 90.3764;
        $get_user = DB::select(
               'SELECT * FROM
                (SELECT id, name, email, image, latitude, langitude,date_of_birth,Gander,DATE_FORMAT(NOW(), "%Y") - DATE_FORMAT(date_of_birth, "%Y") - (DATE_FORMAT(NOW(), "00-%m-%d") < DATE_FORMAT(date_of_birth, "00-%m-%d")) AS age,TRUNCATE((' . $circle_radius . ' * acos(cos(radians(' .$lat . ')) * cos(radians(latitude)) *
                    cos(radians(langitude) - radians(' . $lng . ')) +
                    sin(radians(' . $lat . ')) * sin(radians(latitude)))), 2) 
                    AS distance
                    FROM users) AS distances
                WHERE distance < ' . $max_distance . '
                ORDER BY distance;
            ');

        $get_like_info = DB::select("SELECT b.image, b.name, a.both_likes FROM tbl_likes a
                                    INNER JOIN users b ON b.id = a.profile_id
                                    WHERE a.user_id = $user->id AND a.likes = 1");

        $get_both_like_info = DB::select("SELECT * FROM tbl_likes WHERE user_id = $user->id AND both_likes = 1");

        return view('home')->with('users', $get_user)->with('get_like_infos', $get_both_like_info)->with('user_like_info', $get_like_info);

        

        
    }
}
