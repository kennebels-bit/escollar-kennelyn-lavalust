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
            background: #f1f5f9;
            color: #334155;
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
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
            max-width: 480px;
        }
        .badge {
            display: inline-block;
            background: #dbeafe;
            color: #2563eb;
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
            color: #2563eb;
            font-size: 30px;
            margin: 0 0 14px;
        }
        p.subtitle {
            font-size: 15px;
            line-height: 1.6;
            color: #64748b;
            margin: 0 0 28px;
        }
        nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }
        nav a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            background: #eff6ff;
            border: 1.5px solid #bfdbfe;
            padding: 10px 22px;
            border-radius: 999px;
            transition: all 0.2s ease;
        }
        nav a:hover {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .activity-nav {
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    
    <div class="card">
        <span class="badge">Student Portal</span>
        <h1>Welcome, Kennelyn!</h1>
        <p class="subtitle">This is the home page for Kennelyn Escollar's Student Information System.</p>
        <nav class="activity-nav" aria-label="Activity navigation">
            <a href="<?= site_url() ?>">← Activities</a>
            <a href="<?= site_url('student') ?>">Student</a>
            <a href="<?= site_url('users') ?>">Users</a>
            <a href="<?= site_url('login') ?>">Products</a>
        </nav>
        <nav aria-label="Student navigation">
            <a href="<?= site_url('student') ?>">Home</a>
            <a href="<?= site_url('student/profile') ?>">Profile</a>
        </nav>
    </div>
</body>
</html>