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

	    	//Testing Code Start
	    	$get_dislikelike_info = DB::table('tbl_likes')->where('user_id', $Auth_user_id)->where('profile_id', $profile_user_id)->first();
	    	if($get_dislikelike_info != null){

	    		if($get_dislikelike_info->likes == 1){
	    			DB::table('tbl_likes')->where('id', $get_dislikelike_info->id)->update([
		    			'likes' => 1,
		    			'both_likes' => 1,
		    			'dislikes' => 0,
		    		]);
	    		}else{
	    			DB::table('tbl_likes')->where('id', $get_dislikelike_info->id)->update([
		    			'likes' => 1,
			    		'dislikes' => 0,
			    		'both_likes' => 1,
		    		]);

	    		}

	    		

	    		$another_dislike_info = DB::table('tbl_likes')->where('user_id', $profile_user_id)->where('profile_id', $Auth_user_id)->first();
	    		if($another_dislike_info != null){
	    			if($another_dislike_info->likes == 1){
	    				DB::table('tbl_likes')->where('id', $another_dislike_info->id)->update([
			    			'likes' => 1,
			    			'both_likes' => 1,
			    			'dislikes' => 0,
			    		]);
	    			}else{
	    				DB::table('tbl_likes')->where('id', $another_dislike_info->id)->update([
			    			'likes' => 1,
			    			'dislikes' => 0,
			    		]);
	    			}
	    			
	    		}
	    	}else{
	    		$get_like_info = DB::table('tbl_likes')->where('user_id', $profile_user_id)->where('profile_id', $Auth_user_id)->first();
		    	
		    	//dd($get_like_info->likes);
		    	if($get_like_info == null){
		    		Tbl_likes::create([
			            'user_id' => $Auth_user_id,
			            'profile_id' => $profile_user_id,
			            'likes' => 1,
			            'both_likes' => 0,
			            'dislikes' => 0
			        ]);
		    	}else{	
		    		if($get_like_info->likes == 1){
						DB::table('tbl_likes')->where('user_id', $profile_user_id)->update(['both_likes' => 1]);

						Tbl_likes::create([
				            'user_id' => $Auth_user_id,
				            'profile_id' => $profile_user_id,
				            'likes' => 1,
				            'both_likes' => 1,
				            'dislikes' => 0
				        ]);
					}else{
						Tbl_likes::create([
				            'user_id' => $Auth_user_id,
				            'profile_id' => $profile_user_id,
				            'likes' => 1,
				            'both_likes' => 0,
			            	'dislikes' => 0
				        ]);
					}

		    	}
	    	}
	    	

	    	//Testing Code End

				
	    	$get_both_like_info = DB::table('tbl_likes')->where('user_id', $profile_user_id)->where('profile_id', $Auth_user_id)->first();
	    	if($get_both_like_info != null){
	    		if($get_both_like_info->both_likes == 1){
		    		session()->flash('success', 'Like successfully');
		    	}
	    	}
	    
	        
	        return redirect(route('home'));
	    }




	    public function manageDislike($profile_user_id){

	    	$user = Auth::user();
	    	$Auth_user_id = $user->id;
	    	//dd($Auth_user_id);
	    	
	    	$get_like_info = DB::table('tbl_likes')->where('user_id', $Auth_user_id)->where('profile_id', $profile_user_id)->first();
	    	
	    	if($get_like_info != null){
	    		//dd($get_like_info->id);
	    		DB::table('tbl_likes')->where('id', $get_like_info->id)->update([
	    			'likes' => 0,
	    			'both_likes' => 0,
	    			'dislikes' => 1,
	    		]);

	    		$another_like_info = DB::table('tbl_likes')->where('user_id', $profile_user_id)->where('profile_id', $Auth_user_id)->first();
	    		if($another_like_info != null){
	    			DB::table('tbl_likes')->where('id', $another_like_info->id)->update([
		    			'likes' => 1,
		    			'both_likes' => 0,
		    			'dislikes' => 0,
		    		]);
	    		}

	    	}else{
	    		Tbl_likes::create([
			            'user_id' => $Auth_user_id,
			            'profile_id' => $profile_user_id,
			            'likes' => 0,
			            'both_likes' => 0,
		            	'dislikes' => 1
			        ]);
	    	}

	    	return redirect(route('home'));
	    }
	

}
