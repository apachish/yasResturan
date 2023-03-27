<?php

namespace App\Http\Livewire;

use App\Models\Food;
use Livewire\Component;

class MenuDetiles extends Component
{
    public $description = null;
    public $title = null;
    public string $image = "default.png";
    protected $listeners=["modalFood"=>"modalFood"];

    public function mount()
    {
        $this->description= __("messages.There is no explanation");
    }

    public function modalFood($food_id)
    {
        $food = Food::find($food_id);
        if($food){
            $this->description = $food->description;
            $this->image = $food->image;
            $this->title = $food->title;
        }

    }
    public function render()
    {
        return view('livewire.menu-detiles');
    }
}
