<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Menu as MenuAlias;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateUpdateCategory extends Component
{
    public $category;
    public $menu_ids;
    public $menus = [];
    public $category_id;

    protected $listeners = ['getCategory' => 'setParameter'];


    public function mount()
    {
        $this->menus = MenuAlias::where("status",1)->get();
        if($this->category_id)
            $this->category = Category::find($this->category_id);
        else
            $this->category = new Category();
    }

    public function rules()
    {
        if(is_array($this->menu_ids) && in_array("انتخاب کنید",$this->menu_ids))
        {
            $i = array_search("انتخاب کنید",$this->menu_ids);
            unset($this->menu_ids[$i]);
        }

        $rule = [
            'category.title' => 'required|min:3',
            'menu_ids' => 'bail|nullable|array',
            'menu_ids.*' => 'required_if:menu_ids,>,0|exists:menus,id',
            'category.status'=>['required',Rule::in([
                "1",
                "-1",
            ])]
        ];
        return $rule;
    }


    public function setParameter($model_id)
    {
        $this->category_id = $model_id;
        $this->category = Category::with("menus")->find($this->category_id);
        if($this->category) {
            $this->menu_ids = $this->category->menus->pluck("id");
        }
    }

    public function createUpdateCategory()
    {
        $this->validate();
        $category = $this->category->create($this->category->toArray());
        if($category) {
            $category->menus()->sync($this->menu_ids);
            session()->flash('message', __("messages.Category Created"));
            return redirect()->intended(route("categories"));
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in creating the category"));
        return redirect()->intended(route("categories"));
    }

    public function editUpdateCategory()
    {
        $this->validate();
        if($this->category) {
            $this->category->update([
                'title' => $this->category->title,
                'parent_id' => null,
                'status' => $this->category->status
            ]);
            $this->category->menus()->sync($this->menu_ids?:[]);
            session()->flash('message', __("messages.Category Edited"));
            return redirect()->intended(route("categories"));

        }
        session()->flash('error', __("messages.Unfortunately, there was an error in editing the category"));
        return redirect()->intended(route("categories"));

    }

    public function cancel()
    {
        $this->category= null;
    }
    public function render()
    {
        return view('livewire.admin.create-upate-category');
    }
}
