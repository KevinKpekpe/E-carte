<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation de mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Réinitialisation de votre mot de passe</h2>

    <p>Bonjour,</p>

    <p>Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>

    <p>
        <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="button">
            Réinitialiser mon mot de passe
        </a>
    </p>

    <p>Ce lien de réinitialisation expirera dans 60 minutes.</p>

    <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action n'est requise.</p>

    <div class="footer">
        <p>Cordialement,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
    