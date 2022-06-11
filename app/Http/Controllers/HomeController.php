<?php

namespace App\Http\Controllers;

use App\Contracts\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        Meta::addMeta('title', 'Accueil Findtofound');
        Meta::addMeta('description', 'Plate-forme de recherche des pièces perduées et retrouvées par des tiès et autres personners');
        Meta::addMeta('robots', 'Index, follow');
        return Inertia::render('Home');
    }
}
