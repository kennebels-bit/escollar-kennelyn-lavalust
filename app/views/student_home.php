<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Home - Kennelyn Escollar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #ffdde1 0%, #ffe8f0 40%, #fff0f6 100%);
            color: #5b3a4a;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .bg-decor {
            position: fixed;
            font-size: 28px;
            opacity: 0.5;
            pointer-events: none;
        }
        .bg-decor.tl { top: 30px; left: 40px; }
        .bg-decor.br { bottom: 30px; right: 40px; }
        .bg-decor.tr { top: 40px; right: 60px; }
        .bg-decor.bl { bottom: 50px; left: 60px; }

        .card {
            background: #fffafc;
            padding: 48px 56px;
            border-radius: 28px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(255, 133, 161, 0.25);
            border: 1px solid #ffd6e3;
            max-width: 480px;
        }
        .badge {
            display: inline-block;
            background: #ffd6e3;
            color: #b5495b;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 18px;
            text-transform: uppercase;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: #e05a7d;
            font-size: 30px;
            margin: 0 0 14px;
        }
        p.subtitle {
            font-size: 15px;
            line-height: 1.6;
            color: #8a6272;
            margin: 0 0 28px;
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        nav a {
            color: #e05a7d;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            background: #fff0f5;
            border: 1.5px solid #ffb6c9;
            padding: 10px 22px;
            border-radius: 999px;
            transition: all 0.2s ease;
        }
        nav a:hover {
            background: #ff8fa8;
            color: #ffffff;
            border-color: #ff8fa8;
        }
    </style>
</head>
<body>
    
    <div class="card">
        <span class="badge">Student Portal</span>
        <h1>Welcome, Kennelyn!</h1>
        <p class="subtitle">This is the home page for Kennelyn Escollar's Student Information System.</p>
        <nav>
            <a href="<?= site_url('student') ?>">🏠 Home</a>
            <a href="<?= site_url('student/profile') ?>"> Profile</a>
        </nav>
    </div>
</body>
</html>