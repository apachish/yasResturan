<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class DeleteItem extends Component
{
    public $title;
    public $item_id;
    public $callBack;

    protected $listeners = ["getTitleDelete"=>"getTitle"];

    public function getTitle($title,$item_id,$callBack)
    {
        $this->title = $title;
        $this->item_id = $item_id;
        $this->callBack = $callBack;
    }

    public function delete($item_id)
    {
        $this->emit($this->callBack,$item_id);
    }
    public function render()
    {
        return view('livewire.admin.delete-item');
    }
}
