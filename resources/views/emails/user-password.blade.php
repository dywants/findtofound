@component('mail::message')
# Bienvenue sur FindToFound

Bonjour {{ $user->name }},

Votre compte a été créé avec succès. Voici vos informations de connexion :

**Email :** {{ $user->email }}
**Mot de passe temporaire :** {{ $password }}

Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe dès votre première connexion.

@component('mail::button', ['url' => route('login')])
Se connecter
@endcomponent

Merci de votre confiance,<br>
L'équipe {{ config('app.name') }}
@endcomponent
