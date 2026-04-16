<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre lien d'inscription</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background-color: #fff; border-radius: 8px; padding: 40px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #B3A96F; font-size: 28px; }
        .btn { display: inline-block; background-color: #c42827; color: #fff; text-decoration: none; padding: 14px 32px; border-radius: 4px; font-size: 18px; font-weight: bold; margin: 20px 0; }
        .footer { margin-top: 40px; font-size: 13px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <figure>
            <img src="{{ asset('storage/Logo.png') }}" alt="U-Trail Limal Logo" style="max-width: 150px; margin-bottom: 20px;">
            </figure>
        </div>
        <ul>
    <li><strong>Prénom:</strong> {{ $contactForm->prenom }}</li>
    <li><strong>Nom:</strong> {{ $contactForm->nom }}</li>
    <li><strong>Email:</strong> {{ $contactForm->email }}</li>
    <li><strong>Téléphone:</strong> {{ $contactForm->telephone }}</li>
    <li><strong>Message:</strong> {{ $contactForm->message }}</li>
</ul>
<div class="reponse">
    <p>Vous pouvez répondre à ce message en utilisant l'adresse email suivante : <a href="mailto:{{ $contactForm->email }}">{{ $contactForm->email }}</a></p>
</div>
</body>
</html>
