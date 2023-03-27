<?php

namespace App\Http\Livewire;

use App\Models\PopularFood;
use App\Models\Slide;
use Livewire\Component;

class Home extends Component
{
    public $slides;
    public $popular_foods;
    public function render()
    {
        $this->slides = Slide::where("status",1)->get();
        $this->popular_foods = PopularFood::where("status",1)->get();
        return view('livewire.home')->layout("layouts.front");
    }
}
