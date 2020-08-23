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

        $temp_data = DB::table('temp_data')->where('user_id', $user->id)->latest('id')->first();

        $circle_radius = 9500;
        $max_distance = 5;
        $lat = $temp_data->latitude;
        $lng = $temp_data->longitude;
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

        $get_dislike_info = DB::select("SELECT b.image, b.name,a.both_likes FROM tbl_likes a
                            INNER JOIN users b ON b.id = a.profile_id
                            WHERE a.user_id = $user->id AND a.dislikes = 1");

        return view('home')->with('users', $get_user)->with('get_both_like_info', $get_both_like_info)->with('user_like_info', $get_like_info)->with('get_dislike_infos', $get_dislike_info);

        

        
    }
}
