<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #FF6C2C;
        }
        .header h2 {
            color: #1D1D1B;
            font-size: 24px;
            margin: 0;
        }
        .button {
            display: inline-block;
            padding: 14px 32px;
            background-color: #FF6C2C;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #FF8F2C;
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
            color: #1D1D1B;
            background-color: #FFF4ED;
            border: 1px solid #FFE4D6;
            padding: 16px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .warning strong {
            color: #FF6C2C;
        }
        .verification-link {
            background-color: #F5F5F5;
            padding: 12px;
            border-radius: 4px;
            word-break: break-all;
            color: #666666;
            font-size: 14px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        p {
            color: #1D1D1B;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <!-- Si vous avez un logo -->
            <!-- <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="logo"> -->
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
        <div class="verification-link">
            {{ $verificationUrl }}
        </div>

        <p>Si vous n'avez pas créé de compte sur {{ config('app.name') }}, vous pouvez ignorer cet email.</p>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p style="color: #999999;">&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
