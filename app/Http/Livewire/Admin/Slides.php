<?php

namespace App\Http\Livewire\Admin;

use App\Models\Slide;
use Livewire\Component;
use Livewire\WithPagination;

class Slides extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["updateSlidesReview" => '$refresh',"DeleteSlide"=>"DeleteSlide"];

    public $limit = 10;
    public $count_items = 0;
    public $filter = [];


    public function mount()
    {
    }

    public function delete($slide_id)
    {
        $slide = Slide::find($slide_id);
        if ($slide){
            $this->emit("getTitleDelete",$slide->title,$slide_id,"DeleteSlide");
        }

    }

    public function DeleteSlide($slide_id)
    {
        $slide = Slide::find($slide_id);
        if ($slide){
            $slide->delete();
            session()->flash('message', __("messages.Slide Deleted"));
            $this->emit("updateSlidesReview");
            return true;
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in deleting the slide"));

    }




    public function render()
    {
        $slides =   Slide::orderBy('updated_at', 'desc');
        foreach ($this->filter as $key => $filter) {
            if (in_array($key, ["status","category_id"]) && $filter>=0) {
                $slides->where($key, $filter);
            }
            elseif (in_array($key, ["price"]))
                $slides->where($key, ">=", $filter);
            elseif (in_array($key, ["title"]))
                $slides->where($key, "like", "%" . $filter . "%");
        }
        $this->count_items = $slides->count();
        $slides  = $slides->paginate($this->limit);
        return view('livewire.admin.slides',compact("slides"));
    }
}
