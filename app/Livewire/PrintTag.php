<?php

namespace App\Livewire;

use App\Models\Company;
use Illuminate\Http\Request;
use Livewire\Component;

class PrintTag extends Component
{
    public Company $company;
    public $tagi;
    public $tagf;
    public $nump;

    public function mount(Company $company, Request $request)
    {
        $this->tagi = $request->query('tagi', null);
        $this->tagf = $request->query('tagf', null);
        $this->nump = $request->query('nump', null);
        $this->company = $company;
    }

    public function render()
    {
        return view('livewire.print-tag');
    }
}
