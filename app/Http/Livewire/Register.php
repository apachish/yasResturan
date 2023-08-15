<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $family = '';
    public $mobile = '';
    public $national_code = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|min:2',
        'family' => 'required|min:3',
        'mobile' => 'required|numeric|iran_mobile|unique:users',
        'national_code' => 'required|numeric|melli_code|unique:users',
        'password' => 'required|min:6'
    ];

    public function mount()
    {
        if (auth()->user()) {
            redirect('/dashboard');
        }
    }

    public function register()
    {
        if ($this->mobile && strlen($this->mobile) >= 10 && strlen($this->mobile) <= 11)
            $this->mobile = phone($this->mobile, ["IR"])->formatForMobileDialingInCountry("IR");
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'family' => $this->family,
            'mobile' => $this->mobile,
            'national_code' => $this->national_code,
            'password' => Hash::make($this->password)
        ]);
        $user->syncRoles("customer");

        auth()->login($user);

        return redirect('/admin');
    }

    public function render()
    {
        return view('livewire.register')->layout("layouts.auth");
    }
}
