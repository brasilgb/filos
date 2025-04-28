<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagPageController extends Controller
{
    public function printTags(Request $request) {
        $dataForm = $request->all();
        dd($dataForm);
        return view('filament.pages.print-tag', ['dataForm' => $dataForm]);
    }
} 
