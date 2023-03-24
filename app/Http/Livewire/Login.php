<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public $national_code;
    public $password;


    public function login()
    {
        $validatedDate = $this->validate([
            'national_code' => 'required|numeric',
            'password' => 'required',
        ]);

        if(Auth::attempt(array('national_code' => $this->national_code, 'password' => $this->password))){
            session()->flash('message', "You are Login successful.");
            session()->regenerate();

            return redirect()->intended(route("dashboard"));
        }else{
            session()->flash('error', 'email and password are wrong.');
        }
    }

    public function render()
    {
        return view('livewire.login')->layout("layouts.auth");
    }
}
