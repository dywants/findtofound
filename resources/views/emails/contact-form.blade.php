@component('mail::message')
# Nouveau message de contact

Vous avez reçu un nouveau message de contact via le formulaire du site web FindToFound.

## Détails du message
**Nom**: {{ $name }}  
**Email**: {{ $email }}  
**Sujet**: {{ $subject }}

## Message
{{ $message }}

@component('mail::button', ['url' => route('login')])
Se connecter au tableau de bord
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
