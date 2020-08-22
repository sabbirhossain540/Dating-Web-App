<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Tbl_likes;

class LikesController extends Controller
{
    public function manageLikes($profile_user_id){
    	$user = Auth::user();
    	$Auth_user_id = $user->id;
    	$get_like_info = DB::table('tbl_likes')->where('user_id', $profile_user_id)->where('profile_id', $Auth_user_id)->first();
    	
    	//dd($get_like_info->likes);
    	if($get_like_info == null){
    		Tbl_likes::create([
	            'user_id' => $Auth_user_id,
	            'profile_id' => $profile_user_id,
	            'likes' => 1,
	            'both_likes' => 0
	        ]);
    	}else{	
    		if($get_like_info->likes == 1){
				DB::table('tbl_likes')->where('user_id', $profile_user_id)->update(['both_likes' => 1]);

				Tbl_likes::create([
		            'user_id' => $Auth_user_id,
		            'profile_id' => $profile_user_id,
		            'likes' => 1,
		            'both_likes' => 1
		        ]);
			}else{
				Tbl_likes::create([
		            'user_id' => $Auth_user_id,
		            'profile_id' => $profile_user_id,
		            'likes' => 1,
		            'both_likes' => 0
		        ]);
			}

    	}

			
    	$get_both_like_info = DB::table('tbl_likes')->where('user_id', $profile_user_id)->where('profile_id', $Auth_user_id)->first();
    	if($get_both_like_info != null){
    		if($get_both_like_info->both_likes == 1){
	    		session()->flash('success', 'Like successfully');
	    	}
    	}
    	

	        
	        return redirect(route('home'));
	    }




	    public function manageDislike($profile_user_id){
	    	dd($profile_user_id);
	    }
	

}
