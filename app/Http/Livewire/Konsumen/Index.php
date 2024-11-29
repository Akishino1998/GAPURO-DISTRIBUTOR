<?php

namespace App\Http\Livewire\Konsumen;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $limitPerPage = 50;
    public $search;
    public $jenis_pelanggan;
    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 25;
    }
    public function render()
    {
        $user = User::latest()->where('id_role',5);
        if ($this->search != null) {
            $user= $user->where(function ($query) {
                $query->where('name',"LIKE","%".$this->search."%");
            });
        }
        $countUser = COUNT($user->get());
        $user = $user->paginate($this->limitPerPage);
        return view('livewire.konsumen.index',compact('user','countUser'));
    }
}
