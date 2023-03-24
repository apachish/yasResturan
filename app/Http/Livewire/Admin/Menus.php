<?php

namespace App\Http\Livewire\Admin;

use App\Models\Menu as MenuAlias;
use Livewire\Component;
use Livewire\WithPagination;

class Menus extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["updateMenusReview" => '$refresh',"DeleteMenu"=>"DeleteMenu"];

    public $limit = 10;
    public $count_items = 0;
    public $filter = [];


    public function delete($menu_id)
    {
        $menu = MenuAlias::find($menu_id);
        if ($menu){
            $this->emit("getTitleDelete",$menu->title,$menu_id,"DeleteMenu");
        }

    }

    public function DeleteMenu($menu_id)
    {
        $menu = MenuAlias::find($menu_id);
        if ($menu){
            $menu->delete();
            session()->flash('message', __("messages.Menu Deleted"));
            $this->emit("updateMenusReview");
            return true;
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in deleting the menu"));

    }

    public function render()
    {
        $menus =   MenuAlias::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status"]) && $filter>=0) {
                $menus->where($key, $filter);
            }
            elseif (in_array($key, ["title"]))
                $menus->where($key, "like", "%" . $filter . "%");
        }
        $this->count_items = $menus->count();
        $menus  = $menus->paginate($this->limit);
        return view('livewire.admin.menus',compact("menus"));
    }
}
