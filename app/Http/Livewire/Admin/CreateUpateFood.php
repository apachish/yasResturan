<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Food;
use App\Models\Menu as MenuAlias;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateUpateFood extends Component
{
    public $food;
    public $food_id;
    public $menu_ids;
    public $categories = [];



    public function mount()
    {
        $this->categories = Category::where("status",1)->get();
        $this->menus = MenuAlias::where("status",1)->get();
        if($this->food_id)
        {
            $this->food = Food::find($this->food_id);
            $this->menu_ids = $this->food->menus->pluck("id");

        }
        else
            $this->food = new Food();
    }

    public function rules()
    {
        if(is_array($this->menu_ids) && in_array("انتخاب کنید",$this->menu_ids))
        {
            $i = array_search("انتخاب کنید",$this->menu_ids);
            unset($this->menu_ids[$i]);
        }
        $rule = [
            'food.title' => 'required|min:3',
            'food.price' => 'required|string',
            'food.description' => 'nullable|string',
            'food.category_id' => 'required|exists:categories,id',
            'menu_ids' => 'nullable|array',
            'menu_ids.*' => 'nullable|exists:menus,id',
            'food.status'=>['required',Rule::in([
                "1",
                "-1",
            ])]
        ];
        return $rule;
    }


    public function createUpdateFood()
    {
        if(data_get($this->food,'price'))
            data_set($this->food,'price' , (str_replace(',', '', str_replace("ریال", "", data_get($this->food,'price')))));
        $this->validate();

        $this->food = $this->food->create($this->food->toArray());
        $this->food->menus()->sync($this->menu_ids);

        if($this->food) {
            session()->flash('message', __("messages.Food Created"));
            return redirect()->intended(route("dashboard"));
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in creating the food"));
        return redirect()->intended(route("dashboard"));
    }

    public function editUpdateFood()
    {
        if(data_get($this->food,'price'))
            data_set($this->food,'price' , (str_replace(',', '', str_replace("ریال", "", data_get($this->food,'price')))));
        $this->validate();
        if($this->food) {
            $this->food->update([
                'title' => $this->food->title,
                'price' => $this->food->price,
                'description' => $this->food->description,
                'category_id' => $this->food->category_id,
                'status' => $this->food->status
            ]);
            $this->food->menus()->sync($this->menu_ids);
            session()->flash('message', __("messages.Food Edited"));
            return redirect()->intended(route("dashboard"));

        }
        session()->flash('error', __("messages.Unfortunately, there was an error in editing the food"));
        return redirect()->intended(route("dashboard"));
    }

    public function cancel()
    {
        $this->food= null;
    }

    public function render()
    {
        return view('livewire.admin.create-upate-food');
    }
}
