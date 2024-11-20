<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            text-align: center;
            font-size: 0.9em;
            color: #666666;
        }
        .warning {
            color: #856404;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 12px;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Vérification de votre compte</h2>
    </div>

    <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>

    <p>Nous vous remercions de votre inscription sur {{ config('app.name') }}. Pour activer votre compte et accéder à tous nos services, veuillez cliquer sur le bouton ci-dessous :</p>

    <div style="text-align: center;">
        <a href="{{ $verificationUrl }}" class="button">
            Vérifier mon adresse email
        </a>
    </div>

    <div class="warning">
        <strong>Important :</strong> Ce lien de vérification expirera dans 10 minutes pour des raisons de sécurité.
    </div>

    <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller le lien suivant dans votre navigateur :</p>
    <p style="word-break: break-all;">{{ $verificationUrl }}</p>

    <p>Si vous n'avez pas créé de compte sur {{ config('app.name') }}, vous pouvez ignorer cet email.</p>

    <div class="footer">
        <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
    </div>
</body>
</html>
