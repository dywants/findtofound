<?php

namespace App\Http\Controllers;

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
       return Inertia::render('Faqs', [
           'faqs' => $faqs
       ]);
   }
}
