<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\profile;
use App\Models\User;
use App\Notifications\NewFollowerNotification;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class profileController extends Controller
{
    public function index($username = null)
    {
        if ($username == null) {
            $user = Auth::user();
        } else {
            $user = User::where("username", $username)->first();
            if (!$user) {
                abort(404);
            }
        }
        return view('profile.index', [
            'user' => $user,
        ]);
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'first_name' => ['max:255'],
            'last_name' => ['max:255'],
            'birthday' => ['date_format:Y-m-d'],
            'gender' => ['in:male,female'],
            'avatar' => 'image',
            'bio' => 'nullable',
            'hour_rate' => 'nullable|numeric|min:0'
        ]);

        $data = $request->except('avatar');
        $oldAvatar = false;;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $data['avatar'] = $file->store('avatars', 'public');
            $oldAvatar = $user->profile->avatar;
        }

        /*
        if ($user->profile->id) {
            $user->profile->update($data);
        } else {
            $user->profile()->create($data);
        } 
        */

        profile::updateOrCreate([
            'user_id' => $user->id,
        ], $data);

        if ($oldAvatar) {
            Storage::disk('public')->delete($oldAvatar);
        }
        return redirect()->route('profile.edit')->with('flashMessage', 'Profile updated');
    }
    public function follow(Request $request)
    {
        $request->validate([
            'following_id' => "required|exists:users,id"
        ]);
        $follower = Auth::user();
        $follwing_id = $request->post('following_id');

        if (!$follower->following($follwing_id)) {
            $follower->followings()->attach($follwing_id);
        }
        $following = User::find($follwing_id);
        $following->notify(new NewFollowerNotification($follower));
        return redirect()->back();
    }
    public function unfollow(Request $request)
    {
        $request->validate([
            'following_id' => "required|exists:users,id"
        ]);
        $follower = Auth::user();
        $follwing_id = $request->post('following_id');
        $follower->followings()->detach($follwing_id);

        return redirect()->back();
    }
}
