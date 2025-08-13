<?php

namespace App\Http\Controllers;

use App\Models\Depoimento;

class HomeController extends Controller
{
    public function index()
    {
        $depoimentos = Depoimento::with('user')
            ->latest()
            ->take(4)
            ->get();

        return view('index', compact('depoimentos'));
    }
}