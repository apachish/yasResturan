<?php

namespace App\Http\Livewire\Admin;

use App\Exports\FoodExport;
use App\Models\PopularFood;
use Livewire\Component;
use Livewire\WithPagination;

class PopularFoods extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["updateFoodsReview" => '$refresh',"DeletePopularFood"=>"DeletePopularFood"];

    public $limit = 10;
    public $count_items = 0;
    public $filter = [];


    public function mount()
    {
    }

    public function delete($popular_food_id)
    {
        $popular_food = PopularFood::find($popular_food_id);
        if ($popular_food){
            $this->emit("getTitleDelete",$popular_food->title,$popular_food_id,"DeletePopularFood");
        }

    }

    public function DeletePopularFood($popular_food_id)
    {
        $popular_food = PopularFood::find($popular_food_id);
        if ($popular_food){
            $popular_food->delete();
            session()->flash('message', __("messages.Food Deleted"));
            $this->emit("updateFoodsReview");
            return true;
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in deleting the popular_food"));

    }




    public function render()
    {
        $popular_foods =   PopularFood::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status","category_id"]) && $filter>=0) {
                $popular_foods->where($key, $filter);
            }
            elseif (in_array($key, ["price"]))
                $popular_foods->where($key, ">=", $filter);
            elseif (in_array($key, ["title"]))
                $popular_foods->where($key, "like", "%" . $filter . "%");
        }
        $this->count_items = $popular_foods->count();
        $popular_foods  = $popular_foods->paginate($this->limit);
        return view('livewire.admin.popular-foods',compact("popular_foods"));
    }

}
