<?php

namespace App\Http\Controllers\Pembelajaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembelajaranControllers extends Controller
{
    //
    public function index()
    {
        //
        return view('pembelajaran.index_pembelajaran');
    }
}
