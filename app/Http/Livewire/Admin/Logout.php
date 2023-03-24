<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Logout extends Component
{

    public function logout()
    {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect()->intended(route("login"));
    }
    public function render()
    {
        return view('livewire.admin.logout');
    }
}
