<?php

namespace App\Http\Controllers;

use App\Contracts\Meta;
use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqsIndexController extends Controller
{

    /**
     * @return \Inertia\Response
     */
   public function __invoke(): \Inertia\Response
   {
       $faqs = Faq::latest()->get();
       Meta::addMeta('title', 'Page Faqs!');
       Meta::addMeta('description', "Nous repondons à vos questions courants!");
       Meta::addMeta('robots', 'Index, follow');
       return Inertia::render('Faqs', [
           'faqs' => $faqs
       ]);
   }
}
