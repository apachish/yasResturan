<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Food;
use App\Models\Menu as MenuAlias;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateUpdateFood extends Component
{
    use WithFileUploads;

    public $food;
    public $food_id;
    public $menu_ids;
    public $categories = [];
    public $upload;



    public function mount()
    {
        $this->categories = Category::where("status",1)->get();
        $this->menus = MenuAlias::where("status",1)->get();
        if($this->food_id)
        {
            $this->food = Food::find($this->food_id);
            if($this->food && $this->food->menus)
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
            'upload' => $this->food_id?'nullable|mimes:jpeg,jpg,png|max:10240':'required|mimes:jpeg,jpg,png|max:10240',
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
        if($this->upload)
            $this->food->image = $this->uploadFile();
        $this->food = $this->food->create($this->food->toArray());
        $this->food->menus()->sync($this->menu_ids);

        if($this->food) {
            session()->flash('message', __("messages.Food Created"));
            return redirect()->intended(route("foods"));
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in creating the food"));
        return redirect()->intended(route("foods"));
    }

    public function editUpdateFood()
    {
        if(data_get($this->food,'price'))
            data_set($this->food,'price' , (str_replace(',', '', str_replace("ریال", "", data_get($this->food,'price')))));
        $this->validate();
        if($this->food) {
            if($this->upload)
                $this->food->image = $this->uploadFile();
            $this->food->update([
                'title' => $this->food->title,
                'image' => $this->food->image,
                'price' => $this->food->price,
                'description' => $this->food->description,
                'category_id' => $this->food->category_id,
                'status' => $this->food->status
            ]);
            $this->food->menus()->sync($this->menu_ids);
            session()->flash('message', __("messages.Food Edited"));
            return redirect()->intended(route("foods"));

        }
        session()->flash('error', __("messages.Unfortunately, there was an error in editing the food"));
        return redirect()->intended(route("foods"));
    }

    public function cancel()
    {
        $this->food= null;
    }

    public function render()
    {
        return view('livewire.admin.create-update-food');
    }

    private function uploadFile(): string
    {

        if ($this->food->image && file_exists(public_path("images/foods/" . $this->food->image))) {
            unlink(public_path("images/foods/" . $this->food->image));
        }

        $name = Str::slug($this->food->title).'_'.time() .".". $this->upload->getClientOriginalExtension();

        //$this->upload->storeAs("foods",$name,"public_images");

        $image = Image::make($this->upload);
        $width = 463;
        $height = 263;
        $image->resize($width, $height);
        $image->save(public_path("images/foods/" . $name));

        return $name;

    }
}
