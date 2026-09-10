<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home - Kennelyn Escollar</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 40px; font-family: Arial, sans-serif; background: #f1f5f9; color: #334155; }
        .card { width: 90%; max-width: 1100px; margin: 0 auto; padding: 30px; background: #fff; border: 1px solid #e2e8f0; border-radius: 15px; box-shadow: 0 10px 30px rgba(15, 23, 42, .08); }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding-bottom: 22px; border-bottom: 1px solid #e2e8f0; }
        .eyebrow { margin: 0 0 6px; color: #64748b; font-size: 13px; }
        h1 { margin: 0; color: #2563eb; font-size: 28px; }
        .subtitle { max-width: 620px; margin: 28px 0; color: #64748b; font-size: 15px; line-height: 1.7; }
        .badge { display: inline-block; padding: 7px 12px; border-radius: 8px; background: #dbeafe; color: #2563eb; font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        .activity-nav, .student-nav { display: flex; flex-wrap: wrap; gap: 8px; }
        .activity-nav a, .student-nav a { display: inline-flex; align-items: center; min-height: 36px; padding: 8px 13px; border: 1px solid #bfdbfe; border-radius: 8px; color: #2563eb; background: #eff6ff; font-size: 13px; font-weight: 600; text-decoration: none; }
        .activity-nav a:hover, .activity-nav .active, .student-nav a:hover { color: #fff; background: #2563eb; border-color: #2563eb; }
        .student-nav { padding-top: 22px; border-top: 1px solid #e2e8f0; }
        @media (max-width: 900px) { body { padding: 20px; } .topbar { align-items: flex-start; flex-direction: column; } }
    </style>
</head>
<body>
    <main class="card">
        <header class="topbar">
            <div>
                <p class="eyebrow">Student Information</p>
                <h1>Student Home</h1>
            </div>
            <nav class="activity-nav" aria-label="Activity navigation">
                <a href="<?= site_url() ?>">&larr; Activities</a>
                <a href="<?= site_url('student') ?>" class="active">Student</a>
                <a href="<?= site_url('users') ?>">Users</a>
                <a href="<?= site_url('login') ?>">Products</a>
            </nav>
        </header>
        <p class="badge">Student Portal</p>
        <p class="subtitle">Welcome to Kennelyn Escollar's Student Information System. Use the profile button below to view the complete student record.</p>
        <nav class="student-nav" aria-label="Student navigation">
            <a href="<?= site_url('student/profile') ?>">View Student Profile</a>
        </nav>
    </main>
</body>
</html>
