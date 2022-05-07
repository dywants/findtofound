<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        return Inertia::render('Home');
    }
}
