<?php

namespace App\Livewire;

use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function generate(Company $company, Request $request)
    {
        $tagi = $request->query('tagi', null);
        $tagf = $request->query('tagf', null);
        $nump = $request->query('nump', null);
        $pdf = Pdf::loadView('livewire.print-tag', [
            'tagi' => $tagi,
            'tagf' => $tagf,
            'nump' => $nump,
            'company' => $company ?? [],
        ])->setPaper('A4', 'landscape');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);   
        
        return $pdf->stream('tags.pdf');
    }
}
