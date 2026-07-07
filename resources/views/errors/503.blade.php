<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Maintenance - {{ config('app.name', 'KNEWTODAY') }}</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #080b12;
            --panel: #101827;
            --border: #263244;
            --text: #eef2f8;
            --muted: #a6b0c2;
            --accent: #f1c75b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 18px;
            background:
                radial-gradient(circle at 50% 0%, rgba(241, 199, 91, 0.12), transparent 34rem),
                linear-gradient(180deg, #0b1020 0%, var(--bg) 62%);
            color: var(--text);
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        main {
            width: min(100%, 680px);
            border: 1px solid var(--border);
            background: rgba(16, 24, 39, 0.88);
            border-radius: 8px;
            padding: clamp(28px, 6vw, 56px);
            text-align: center;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.32);
        }

        .eyebrow {
            margin: 0 0 16px;
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(40px, 10vw, 76px);
            line-height: 0.95;
            letter-spacing: 0.08em;
        }

        h2 {
            margin: 24px 0 0;
            font-size: clamp(22px, 4vw, 32px);
            line-height: 1.15;
        }

        p {
            margin: 18px auto 0;
            max-width: 520px;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.7;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            color: var(--muted);
            font-size: 13px;
        }

        .pulse {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            background: var(--accent);
            box-shadow: 0 0 0 0 rgba(241, 199, 91, 0.58);
            animation: pulse 1.8s infinite;
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @keyframes pulse {
            70% {
                box-shadow: 0 0 0 12px rgba(241, 199, 91, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(241, 199, 91, 0);
            }
        }
    </style>
</head>
<body>
    <main>
        <p class="eyebrow">{{ config('app.name', 'KNEWTODAY') }}</p>
        <h1>503</h1>
        <h2>We are doing a little maintenance.</h2>
        <p>
            The site is temporarily offline while we tune a few things behind the scenes.
            Please check back soon.
        </p>
        <div class="status" aria-live="polite">
            <span class="pulse" aria-hidden="true"></span>
            <span>Service temporarily unavailable</span>
        </div>
        <p>
            Need to reach us? Email
            <a href="mailto:{{ config('mail.reply_to.address', 'support@knewtoday.com') }}">
                {{ config('mail.reply_to.address', 'support@knewtoday.com') }}
            </a>.
        </p>
    </main>
</body>
</html>
