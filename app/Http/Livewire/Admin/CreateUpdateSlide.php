<?php

namespace App\Http\Livewire\Admin;

use App\Models\Slide;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateUpdateSlide extends Component
{
    use WithFileUploads;

    public $slide;
    public $slide_id;
    public $menu_ids;
    public $categories = [];
    public $upload;



    public function mount()
    {
        if($this->slide_id)
        {
            $this->slide = Slide::find($this->slide_id);
            $this->menu_ids = $this->slide->menus->pluck("id");

        }
        else
            $this->slide = new Slide();
    }

    public function rules()
    {
        $rule = [
            'slide.title' => 'required|min:3',
            'slide.description' => 'nullable|string',
            'slide.title_link' => 'nullable|string',
            'slide.link' => 'nullable|string',
            'upload' => $this->slide_id?'nullable|mimes:jpeg,jpg,png|max:10240':'required|mimes:jpeg,jpg,png|max:10240',
            'slide.status'=>['required',Rule::in([
                "1",
                "-1",
            ])]
        ];
        return $rule;
    }


    public function createUpdateSlide()
    {
        $this->validate();
        if($this->upload)
            $this->slide->image = $this->uploadFile();
        $this->slide = $this->slide->create($this->slide->toArray());

        if($this->slide) {
            session()->flash('message', __("messages.Slide Created"));
            return redirect()->intended(route("dashboard"));
        }
        session()->flash('error', __("messages.Unfortunately, there was an error in creating the slide"));
        return redirect()->intended(route("dashboard"));
    }

    public function editUpdateSlide()
    {
        $this->validate();
        if($this->slide) {
            if($this->upload)
                $this->slide->image = $this->uploadFile();
            $this->slide->update([
                'title' => $this->slide->title,
                'image' => $this->slide->image,
                'title_link' => $this->slide->title_link,
                'link' => $this->slide->link,
                'description' => $this->slide->description,
                'status' => $this->slide->status
            ]);
            session()->flash('message', __("messages.Slide Edited"));
            return redirect()->intended(route("dashboard"));

        }
        session()->flash('error', __("messages.Unfortunately, there was an error in editing the slide"));
        return redirect()->intended(route("dashboard"));
    }

    public function cancel()
    {
        $this->slide= null;
    }

    public function render()
    {
        return view('livewire.admin.create-upate-slide');
    }

    private function uploadFile(): string
    {

        if ($this->slide->image && file_exists(public_path("images/slides/" . $this->slide->image))) {
            unlink(public_path("images/slides/" . $this->slide->image));
        }

        $name = Str::slug($this->slide->title).'_'.time() .".". $this->upload->getClientOriginalExtension();

        //$this->upload->storeAs("slides",$name,"public_images");

        $image = Image::make($this->upload);
        $width = 900;
        $height = 600;
        $image->resize($width, $height);
        $image->save(public_path("images/slides/" . $name));

        return $name;

    }

}
