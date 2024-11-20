<!DOCTYPE html>
<html>
<head>
    <style>
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Bonjour {{ $user->prenom }},</h2>

    <p>Votre compte a été créé avec succès. Pour l'activer, veuillez cliquer sur le bouton ci-dessous :</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $activationUrl }}" class="button" style="color: white;">
            Activer mon compte
        </a>
    </div>

    <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller le lien suivant dans votre navigateur :</p>
    <p>{{ $activationUrl }}</p>

    <p>Ce lien est valable pendant 24 heures.</p>

    <p>Si vous n'avez pas créé de compte, vous pouvez ignorer cet email.</p>

    <p>Cordialement,<br>
    L'équipe {{ config('app.name') }}</p>
</body>
</html>
