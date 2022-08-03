<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class notificationController extends Controller
{
    public function index()
    {
        return view("notifications", [
            "notifications" => Auth::user()->notifications()->paginate()
        ]);
    }
    public function show($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();
        if ($notification->data["action"]) {
            redirect()->to($notification->data["action"]);
        }
        return redirect()->route("notifications");
    }
    public function destroy($id = null)
    {
        $user = Auth::user();
        $user->notifications()->when($id, function ($query, $id) {
            $query->where("id", $id);
        });
        return redirect()->route("notifications");
    }
}
