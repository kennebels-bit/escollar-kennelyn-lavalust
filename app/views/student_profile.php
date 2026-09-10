<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - Kennelyn Escollar</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 40px; font-family: Arial, sans-serif; background: #f1f5f9; color: #334155; }
        .container { width: 90%; max-width: 1100px; margin: 0 auto; padding: 30px; background: #fff; border: 1px solid #e2e8f0; border-radius: 15px; box-shadow: 0 10px 30px rgba(15, 23, 42, .08); }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding-bottom: 22px; border-bottom: 1px solid #e2e8f0; }
        .eyebrow { margin: 0 0 6px; color: #64748b; font-size: 13px; }
        h1 { margin: 0; color: #2563eb; font-size: 28px; }
        .activity-nav, .profile-actions, .socials { display: flex; flex-wrap: wrap; gap: 8px; }
        .activity-nav a, .profile-actions a, .socials a { display: inline-flex; align-items: center; justify-content: center; min-height: 36px; padding: 8px 13px; border: 1px solid #bfdbfe; border-radius: 8px; color: #2563eb; background: #eff6ff; font-size: 13px; font-weight: 600; text-decoration: none; }
        .activity-nav a:hover, .activity-nav .active, .profile-actions a:hover, .socials a:hover { color: #fff; background: #2563eb; border-color: #2563eb; }
        .profile-layout { display: grid; grid-template-columns: 1fr 1.2fr; gap: 30px; padding-top: 30px; }
        .summary { padding: 24px; border-radius: 12px; background: #eff6ff; border: 1px solid #dbeafe; }
        .avatar { display: flex; align-items: center; justify-content: center; width: 76px; height: 76px; margin-bottom: 18px; border-radius: 12px; color: #fff; background: linear-gradient(135deg, #60a5fa, #2563eb); font-size: 30px; }
        .summary h2 { margin: 0 0 8px; color: #1e293b; font-size: 22px; }
        .summary p { margin: 0; color: #64748b; line-height: 1.6; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 28px; }
        .info-row { display: flex; justify-content: space-between; gap: 16px; padding: 13px 0; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        .info-row .label { color: #2563eb; font-weight: 700; }
        .info-row .value { color: #475569; text-align: right; }
        .about { margin-top: 24px; padding: 18px; border-left: 4px solid #2563eb; border-radius: 8px; background: #f8fafc; line-height: 1.6; }
        .about .label { display: block; margin-bottom: 6px; color: #2563eb; font-weight: 700; }
        .socials { margin-top: 22px; }
        .profile-actions { margin-top: 28px; }
        @media (max-width: 900px) { body { padding: 20px; } .topbar { align-items: flex-start; flex-direction: column; } .profile-layout { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="container">
        <header class="topbar">
            <div>
                <p class="eyebrow">Student Information</p>
                <h1>Student Profile</h1>
            </div>
            <nav class="activity-nav" aria-label="Activity navigation">
                <a href="<?= site_url() ?>">&larr; Activities</a>
                <a href="<?= site_url('student') ?>" class="active">Student</a>
                <a href="<?= site_url('users') ?>">Users</a>
                <a href="<?= site_url('login') ?>">Products</a>
            </nav>
        </header>

        <section class="profile-layout">
            <div class="summary">
                <div class="avatar">🎓</div>
                <h2><?= html_escape($name) ?></h2>
                <p><?= html_escape($course) ?>, <?= html_escape($year) ?></p>
                <div class="socials">
                    <a href="<?= $facebook ?>" target="_blank" rel="noopener">Facebook</a>
                    <a href="<?= $github ?>" target="_blank" rel="noopener">GitHub</a>
                </div>
            </div>

            <div>
                <div class="info-grid">
                    <div class="info-row"><span class="label">Student ID</span><span class="value"><?= html_escape($student_id) ?></span></div>
                    <div class="info-row"><span class="label">Section</span><span class="value"><?= html_escape($section) ?></span></div>
                    <div class="info-row"><span class="label">Email</span><span class="value"><?= html_escape($email) ?></span></div>
                    <div class="info-row"><span class="label">Contact</span><span class="value"><?= html_escape($contact) ?></span></div>
                    <div class="info-row"><span class="label">Address</span><span class="value"><?= html_escape($address) ?></span></div>
                    <div class="info-row"><span class="label">Skills</span><span class="value"><?= html_escape($skills) ?></span></div>
                    <div class="info-row"><span class="label">Hobbies</span><span class="value"><?= html_escape($hobbies) ?></span></div>
                </div>
                <div class="about">
                    <span class="label">About Me</span>
                    <?= html_escape($description) ?>
                </div>
                <nav class="profile-actions" aria-label="Student profile navigation">
                    <a href="<?= site_url('student') ?>">&larr; Back to Student Home</a>
                </nav>
            </div>
        </section>
    </main>
</body>
</html>
