<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MainPageController extends Controller
{
    public function index(): View
    {
        return view('welcome');
    }
}
