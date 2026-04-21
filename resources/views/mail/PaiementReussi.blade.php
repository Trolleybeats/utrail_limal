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
        <p>Bonjour <strong>{{ $membre->participant->prenom }} {{ $membre->participant->nom }}</strong>,</p>
        <p>
            Merci pour votre inscription au projet U-Trail Limal !
            Nous avons bien reçu votre paiement et votre inscription est maintenant confirmée.
            Nous sommes ravis de vous compter parmi les participants et avons hâte de vous voir à l'entrainement.
        </p>
        <div class="footer">
            <p>U-Trail Limal &mdash; Ce message a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>