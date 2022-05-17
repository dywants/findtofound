<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        $faqs = Faq::latest()->get();
        return Inertia::render('Pages/Faqs', [
            'faqs' => $faqs
        ]);
    }
}
