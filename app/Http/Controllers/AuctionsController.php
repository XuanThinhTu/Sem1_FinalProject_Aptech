<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuctionsController extends Controller
{
    public function index() {
        return view('pages.auctionspage');
    }
}
