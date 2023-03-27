<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Menu extends Component
{
    public $categories;
    public $type_menu;
    public $menu;

    public function mount($type_menu = null)
    {
        $this->type_menu = $type_menu;
        if($this->type_menu){
            $this->menu =  \App\Models\Menu::where("slug",$type_menu)->first();
        }
    }

    public function render()
    {
        $this->categories = Category::where("status", 1);
        if ($this->type_menu) {
            $this->categories->whereHas("menus", function ($query) {
                $query->where("slug", $this->type_menu);
            });
        }else{
            $this->categories->doesntHave("menus");
        }
        $this->categories->with(["foods" => function ($query) {
            $query->orderBy("title");
            $query->where("status", 1);
            if ($this->type_menu) {
                $query->whereHas("menus", function ($q) {
                    $q->where("slug", $this->type_menu);
                });
            }else{
                $query->doesntHave("menus");
            }
        }]);

        $this->categories = $this->categories->get();
        $this->categories->map(function ($category) {
            $category->slug = Str::slug($category->title);
        });
        return view('livewire.menu')->layout("layouts.front");
    }
}
