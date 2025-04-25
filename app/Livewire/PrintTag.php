<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Component;

class PrintTag extends Component
{
    public Company $company;

    public function mount(Company $company)
    {
        $this->company = $company;
    }

    public function render()
    {
        return view('livewire.print-tag');
    }
}
