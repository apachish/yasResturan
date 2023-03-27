<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Food;
use App\Models\Menu;
use App\Models\PopularFood;
use App\Models\Slide;
use Livewire\Component;

class Dashboard extends Component
{
    public $menu_count=0;
    public $food_count=0;
    public $category_count=0;
    public $slide_count=0;
    public $popular_food_count=0;
    public function render()
    {
        $this->menu_count = Menu::count();
        $this->food_count = Food::count();
        $this->category_count = Category::count();
        $this->slide_count = Slide::count();
        $this->popular_food_count = PopularFood::count();
        return view('livewire.admin.dashboard')->layout("layouts.app");
    }
}
