<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-CARTE RDC</title>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    <style>
        /* Styles de Bootstrap pour les boutons */
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #fff;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 0 20px;
        }

        .btn-custom {
            flex: 1;
            max-width: 200px;
        }

        .social-links {
          display: flex;
          justify-content: center;
          align-items: center;
          gap: 15px;
        }

        .social-icon {
          font-size: 24px;
          color: #333;
          text-decoration: none;
          transition: color 0.3s ease;
        }

        .social-icon:hover {
          color: #007bff;
        }
    </style>
  </head>
  <body>
