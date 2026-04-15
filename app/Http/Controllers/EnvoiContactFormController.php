<?php

namespace App\Http\Controllers;

use App\Mail\EnvoiFormContact;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnvoiContactFormController extends Controller
{
    public function __invoke(Request $request)
    {
    $contactForm=ContactForm::create($request->validate([
        'prenom' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telephone' => 'nullable|string|max:20',
        'message' => 'required|string|max:2000',
    ]));

    Mail::to('admin@test.com')->queue(new EnvoiFormContact(
       $contactForm
    ));

    return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès!');
    }
}
