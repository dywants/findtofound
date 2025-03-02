<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Afficher la page de contact
     */
    public function index()
    {
        return Inertia::render('Contact');
    }

    /**
     * Traiter la soumission du formulaire de contact
     */
    public function submit(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required' => 'Le nom est requis',
            'email.required' => 'L\'adresse email est requise',
            'email.email' => 'L\'adresse email n\'est pas valide',
            'subject.required' => 'Le sujet est requis',
            'message.required' => 'Le message est requis',
            'message.min' => 'Le message doit contenir au moins :min caractères',
        ]);

        // Ici, vous pourriez envoyer un email avec les données du formulaire
        // Mail::to('contact@findtofound.com')->send(new ContactFormMail($validated));
        
        // Stocker le message dans la base de données si nécessaire
        // ContactMessage::create($validated);
        
        // Journaliser la réception d'un nouveau message
        logger()->info('Nouveau message de contact reçu de ' . $validated['email']);

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
