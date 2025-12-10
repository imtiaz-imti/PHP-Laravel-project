<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserImage;
use App\Models\UserFollow;
use App\Models\UserComment;
use App\Models\ImageDetails;

class AppController extends Controller
{
    public function save_details(Request $request)
    {
      $request->validate([
        'profile_photo' => 'required_without_all:bio|image|mimes:jpg,jpeg,png|max:2048',
        'bio' => 'required_without_all:profile_photo|string|max:500'
      ]);
      $user = auth()->user();
      if($request->file('profile_photo')){
      $newFile = $request->file('profile_photo');

      if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
  
          $oldHash = md5(Storage::disk('public')->get($user->profile_photo));
          $newHash = md5(file_get_contents($newFile));
  
          if ($oldHash === $newHash) {
            Storage::disk('public')->delete($user->profile_photo);
          }
      }

      if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
        Storage::disk('public')->delete($user->profile_photo);
      }
    
      $path = $request->file('profile_photo')->store('images', 'public');

      $user->profile_photo = $path;
      }  
      $user->bio = $request->bio;
      $user->save();
      return back();
    }
    public function app_operation(){
      if (!auth()->check()) {
        return redirect('/sign-in');
      }
      $images = UserImage::where('user_id', auth()->id())->get();
      $followings = UserFollow::where('follower_id', auth()->id())->with('following')->get();
      $followers = UserFollow::where('following_id', auth()->id())->with('follower')->get();
      return view('home',['images'=>$images,'followings'=>$followings,'followers'=>$followers]);
    }

    public function search_user(Request $request){
      $search = '';
      if($request->input('search') === ''){
        $search = session('search');
      }
      else{
        $search = trim($request->input('search'));
        $request->session()->put('search', $search);
      }
      $keywords = explode(' ', $search);
      $users = User::query()
        ->where(function ($query) use ($keywords) {
        foreach ($keywords as $word) {
            $query->orWhere('name', 'LIKE', "%{$word}%")
                  ->orWhere('username', 'LIKE', "%{$word}%");
        }
      })
      ->get(); 
      $following = UserFollow::where('follower_id',auth()->user()->id)->get(); 
      return view('search',['users'=>$users,'following'=>$following]);
    }

    public function upload_image(Request $request){
      $request->validate([
        'upload_image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
      ]);
      UserImage::create([
        'user_id' => auth()->user()->id,
        'image_path' => $request->file('upload_image')->store('images', 'public')
      ]);
      return redirect('/');
    }

    public function user_follow($id){
      UserFollow::create([
        'follower_id' => auth()->user()->id,
        'following_id' => $id
      ]);
      return redirect('/search/user');
    }

    public function user_unfollow_remove($id){
      UserFollow::destroy($id);
      return redirect('/');
    }

    public function profile_details($id){
      $details = User::where('id',$id)->get();
      $images = UserImage::where('user_id',$id)->get();
      return view('profile',['details'=>$details,'images'=>$images]);
    }

    public function image_details($id){
      $imageLikes = ImageDetails::where('image_id',$id)->get();
      $details = UserImage::where('id',$id)->get();
      $comments = UserComment::where('image_id', $id)->where('parent_id', null)->with('user')->get();
      $childComments = UserComment::where('image_id', $id)->whereNotNull('parent_id')->get();
      return view('image',['details'=>$details,'id'=>$id,'imageLikes'=>$imageLikes,'comments'=>$comments, 'childComments'=>$childComments]);
    }

    public function image_like($id){
      $detail = ImageDetails::where('image_id', $id)->first();

      if (!$detail) {
          $detail = ImageDetails::create([
              'image_id'        => $id,
              'like_count'      => 1,
              'liked_user_ids'  => [auth()->user()->id],
          ]);
          return redirect()->route('image.details',$id);
      }

      $likedUsers = $detail->liked_user_ids ?? [];

      if (!in_array(auth()->user()->id, $likedUsers)) {
          $likedUsers[] = auth()->user()->id;

          $detail->update([
              'like_count'     => count($likedUsers),
              'liked_user_ids' => $likedUsers,
          ]);
      }
      else{
          $likedUsers = array_values(array_diff($likedUsers, [auth()->user()->id]));
          if(count($likedUsers) === 0){
            ImageDetails::where('image_id', $id)->delete();
          }
          else{
            $detail->update([
              'like_count'     => count($likedUsers),
              'liked_user_ids' => $likedUsers,
            ]);
          }
      }
      return redirect()->route('image.details',$id);
    }
    
    public function user_comment(Request $request,$imageID,$commentID){
      if($commentID === '0'){
        UserComment::create([
          'image_id' => $imageID,
          'user_id'  => auth()->user()->id,      
          'comment'  => $request->input('comment'),
        ]);
      }
      else{
        UserComment::create([
          'image_id' => $imageID,
          'user_id'  => auth()->user()->id,      
          'parent_id' => $commentID,
          'comment'  => $request->input('comment'),
        ]);
      }
      return redirect(url()->previous());
    }

    public function comment_like($id,$imageID){
      $detail = UserComment::where('id', $id)->first();

      
      $likedUsers = $detail->liked_user_ids ?? [];

      if (!in_array(auth()->user()->id, $likedUsers)) {
          $likedUsers[] = auth()->user()->id;

          $detail->update([
              'like_count'     => count($likedUsers),
              'liked_user_ids' => $likedUsers,
          ]);
      }
      else{
          $likedUsers = array_values(array_diff($likedUsers, [auth()->user()->id]));
          
          $detail->update([
            'like_count'     => count($likedUsers),
            'liked_user_ids' => $likedUsers,
          ]);
      }
      return redirect(url()->previous());
    }

    public function comment_details($id,$imageID){
      $comment = UserComment::where('id',$id)->with('user')->get();
      $childComments = UserComment::where('parent_id',$id)->with('user')->get();
      return view('comment',['comment'=>$comment,'id'=>$imageID,'childComments'=>$childComments]);
    }

}
