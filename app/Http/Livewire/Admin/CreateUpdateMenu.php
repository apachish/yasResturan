<?php

namespace App\Http\Livewire\Admin;

use App\Models\Menu;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateUpdateMenu extends Component
{
    public $menu;
    public $menu_id;

    protected $listeners = ['getMenu' => 'setParameter'];


    public function mount()
    {
        if($this->menu_id)
            $this->menu = Menu::find($this->menu_id);
        else
            $this->menu = new Menu();
    }

    public function rules()
    {
        $rule = [
            'menu.title' => 'required|min:3',
            'menu.slug' => 'required|string|unique:menus,slug,'.$this->menu_id,
            'menu.status'=>['required',Rule::in([
                "1",
                "-1",
            ])]
        ];
        return $rule;
    }


    public function setParameter($model_id)
    {
        $this->menu_id = $model_id;
        $this->menu = Menu::find($this->menu_id);
    }

    public function createUpdateMenu()
    {
        $this->validate();
        $menu = $this->menu->create($this->menu->toArray());
        if($menu) {
            session()->flash('message', __("messages.Menu Created"));
            return redirect()->intended(route("dashboard"));
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in creating the menu"));
        return redirect()->intended(route("dashboard"));

    }

    public function editUpdateMenu()
    {
        $this->validate();
        if($this->menu) {
            $this->menu->update([
                'title' => $this->menu->title,
                'parent_id' => $this->menu->parent_id,
                'status' => $this->menu->status
            ]);
            session()->flash('message', __("messages.Menu Edited"));
            return redirect()->intended(route("dashboard"));

        }
        session()->flash('error', __("messages.Unfortunately, there was an error in editing the menu"));
        return redirect()->intended(route("dashboard"));

    }

    public function cancel()
    {
        $this->menu= null;
    }

    public function render()
    {
        return view('livewire.admin.create-update-menu');
    }
}
