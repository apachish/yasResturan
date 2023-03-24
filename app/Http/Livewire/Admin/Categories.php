<?php

namespace App\Http\Livewire\Admin;

use App\Exports\CategoryExport;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Categories extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["updateCategoriesReview" => '$refresh',"DeleteCategory"];

    public $limit = 10;
    public $count_items = 0;
    public $filter = [];



    public function delete($category_id)
    {
        $cqategory = Category::find($category_id);
        if ($cqategory){
            $this->emit("getTitleDelete",$cqategory->title,$category_id,"DeleteCategory");
        }

    }

    public function DeleteCategory($category_id)
    {
        $cqategory = Category::find($category_id);
        if ($cqategory){
            $cqategory->delete();
            session()->flash('message', __("messages.Category Deleted"));
            $this->emit("updateCategoriesReview");
            return true;
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in deleting the menu"));

    }


    public function export()
    {
        return Excel::download(new CategoryExport($this->filter), now()->format("Y_m_D").'_Category.xlsx');
    }

    public function render()
    {
        $categories =   Category::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status"]) && $filter>=0) {
                $categories->where($key, $filter);
            }
            elseif (in_array($key, ["title"]))
                $categories->where($key, "like", "%" . $filter . "%");
        }
        $this->count_items = $categories->count();
        $categories  = $categories->paginate($this->limit);
        return view('livewire.admin.categories',compact("categories"));
    }

}
