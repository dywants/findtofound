<?php

namespace App\Http\Controllers;

use App\Contracts\Meta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactIndexController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function __invoke(): \Inertia\Response
    {
        Meta::addMeta('title', 'Contectez-nous!');
        Meta::addMeta('description', "Cette page permet l'enregistrement des informations d'une pièce retrouvée ainsi que les informations de celui qui à retrouvée la pièce");
        Meta::addMeta('robots', 'Index, follow');
        return Inertia::render('Contact');
    }
}
