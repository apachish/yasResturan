<?php

namespace App\Http\Livewire\Admin;

use App\Models\PopularFood;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateUpdatePopularFood extends Component
{
    use WithFileUploads;

    public $popular_food;
    public $popular_food_id;
    public $upload;



    public function mount()
    {

        if($this->popular_food_id)
            $this->popular_food = PopularFood::find($this->popular_food_id);
        else
            $this->popular_food = new PopularFood();
    }

    public function rules()
    {
        $rule = [
            'popular_food.title' => 'required|min:3',
            'upload' => $this->popular_food_id?'nullable|mimes:jpeg,jpg,png|max:10240':'required|mimes:jpeg,jpg,png|max:10240',
            'popular_food.status'=>['required',Rule::in([
                "1",
                "-1",
            ])]
        ];
        return $rule;
    }


    public function createUpdatePopularFood()
    {
        $this->validate();
        if($this->upload)
            $this->popular_food->image = $this->uploadFile();
        $this->popular_food = $this->popular_food->create($this->popular_food->toArray());

        if($this->popular_food) {
            session()->flash('message', __("messages.Popular Food Created"));
            return redirect()->intended(route("popular-foods"));
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in creating the popular_food"));
        return redirect()->intended(route("popular-foods"));
    }

    public function editUpdatePopularFood()
    {
        $this->validate();
        if($this->popular_food) {
            if($this->upload)
                $this->popular_food->image = $this->uploadFile();
            $this->popular_food->update([
                'title' => $this->popular_food->title,
                'image' => $this->popular_food->image,
                'status' => $this->popular_food->status
            ]);
            session()->flash('message', __("messages.Popular Food Edited"));
            return redirect()->intended(route("popular-foods"));

        }
        session()->flash('error', __("messages.Unfortunately, there was an error in editing the Popular Food"));
        return redirect()->intended(route("popular-foods"));
    }

    public function cancel()
    {
        $this->popular_food= null;
    }

    public function render()
    {
        return view('livewire.admin.create-update-popular-food');
    }

    private function uploadFile(): string
    {

        if ($this->popular_food->image && file_exists(public_path("images/popular_foods/" . $this->popular_food->image))) {
            unlink(public_path("images/popular_foods/" . $this->popular_food->image));
        }

        $name = Str::slug($this->popular_food->title).'_'.time() .".". $this->upload->getClientOriginalExtension();

        //$this->upload->storeAs("popular_foods",$name,"public_images");

        $image = Image::make($this->upload);
        $width = 463;
        $height = 263;
        $image->resize($width, $height);
        $image->save(public_path("images/popular_foods/" . $name));

        return $name;

    }

}
