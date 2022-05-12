<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactIndexController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function __invoke(): \Inertia\Response
    {
        return Inertia::render('Contact');
    }
}
