<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Notification extends Component
{
    public $notifications;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.notification');
    }
}
