<?php

namespace App\Http\Livewire\Admin;

use App\Exports\FoodExport;
use App\Models\Category;
use App\Models\Food;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Foods extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["updateFoodsReview" => '$refresh',"DeleteFood"=>"DeleteFood"];

    public $limit = 10;
    public $count_items = 0;
    public $filter = [];
    public $categories = [];


    public function mount()
    {
        $this->categories = Category::where("status",1)->get();
    }

    public function delete($food_id)
    {
        $food = Food::find($food_id);
        if ($food){
            $this->emit("getTitleDelete",$food->title,$food_id,"DeleteFood");
        }

    }

    public function DeleteFood($food_id)
    {
        $food = Food::find($food_id);
        if ($food){
            $food->delete();
            session()->flash('message', __("messages.Food Deleted"));
            $this->emit("updateFoodsReview");
            return true;
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in deleting the food"));

    }


    public function export()
    {
        return Excel::download(new FoodExport($this->filter), now()->format("Y_m_D").'_Food.xlsx');
    }


    public function render()
    {
        $foods =   Food::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status","category_id"]) && $filter>=0) {
                $foods->where($key, $filter);
            }
            elseif (in_array($key, ["price"]))
                $foods->where($key, ">=", $filter);
            elseif (in_array($key, ["title"]))
                $foods->where($key, "like", "%" . $filter . "%");
        }
        $this->count_items = $foods->count();
        $foods  = $foods->paginate($this->limit);
        return view('livewire.admin.foods',compact("foods"));
    }

}
