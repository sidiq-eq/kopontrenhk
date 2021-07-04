<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Laki_laki extends Controller
{
    //
    public function yangdibutuhkan_laki_laki(Request $request){
        $laki_laki = new laki_laki;
        $request->dompet = 'Required';
        $request->otak = 'Required';
        $request->fisik = 'Required';
        $request->muka = 'Optional';
        
    }
}
