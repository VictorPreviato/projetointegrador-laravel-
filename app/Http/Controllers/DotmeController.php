<?php

namespace App\Http\Controllers;

use App\Models\Dotme;
use Illuminate\Http\Request;

class DotmeController extends Controller
{
    public function create(Request $request){
        if($request->method() == "POST"){
            $data = $request->all();
            Dotme::create($data);

            return redirect('log');
        }

        return view('log');
    }
}
