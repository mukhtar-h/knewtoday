@extends('layouts.public')

@section('title', 'Cookie Policy — KNEWTODAY')

@section('meta_description', 'Learn how KNEWTODAY uses cookies for login, security, and basic site functionality.')

@section('content')
<main class="flex-1">
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-10">

        {{-- Header --}}
        <section class="space-y-2">
            <h1 class="kt-section-title">
                Cookie Policy
            </h1>
            <p class="text-sm text-kt-textMuted max-w-2xl">
                This page explains what cookies are, which cookies KNEWTODAY uses, and how you can control them
                in your browser.
            </p>
            <p class="text-[11px] text-kt-muted">
                Last updated: {{ now()->format('F j, Y') }}
            </p>
        </section>

        {{-- What cookies are --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">
                1. What are cookies?
            </h2>
            <p>
                Cookies are small text files that are stored on your device (computer, phone, tablet) when you visit
                a website. They help the site remember information about your visit, such as your login status
                or preferences, so that the site can work properly and feel more consistent from page to page.
            </p>
        </section>

        {{-- How we use cookies --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">
                2. How KNEWTODAY uses cookies
            </h2>
            <p>
                KNEWTODAY uses cookies primarily to:
            </p>
            <ul class="list-disc list-inside space-y-1">
                <li><span class="text-kt-text">Keep you logged in</span> when you sign in to your account.</li>
                <li><span class="text-kt-text">Protect forms and actions</span> using security tokens (CSRF protection).</li>
                <li><span class="text-kt-text">Remember simple preferences</span> related to how the site behaves.</li>
            </ul>
            <p>
                We do not currently use cookies for advertising, behavioural tracking, or third-party analytics.
                If this changes in the future, this policy will be updated.
            </p>
        </section>

        {{-- Types of cookies --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">
                3. Types of cookies we use
            </h2>

            <div class="space-y-3">
                <div>
                    <p class="text-kt-text font-semibold">
                        3.1 Essential (required) cookies
                    </p>
                    <p>
                        These cookies are necessary for the website to function correctly. Without them, basic
                        features like logging in or submitting forms would not work.
                    </p>
                    <ul class="list-disc list-inside space-y-1 mt-1">
                        <li>
                            <span class="text-kt-text font-semibold">Session cookie</span>
                            (used to keep you logged in and remember your session between page loads).
                        </li>
                        <li>
                            <span class="text-kt-text font-semibold">Security / CSRF cookie</span>
                            (used to protect forms and actions from cross-site request forgery attacks).
                        </li>
                        <li>
                            <span class="text-kt-text font-semibold">“Remember me” cookie</span>
                            (optional cookie set if you choose to stay signed in on this device).
                        </li>
                    </ul>
                </div>

                <div>
                    <p class="text-kt-text font-semibold">
                        3.2 Non-essential cookies
                    </p>
                    <p>
                        At this time, KNEWTODAY does not set analytics, advertising, or social media tracking cookies.
                        If we add such services in the future (for example, Google Analytics), we will update this
                        section to explain what is used and why.
                    </p>
                </div>
            </div>
        </section>

        {{-- Sessions explanation (tying to your question) --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">
                4. Cookies and sessions
            </h2>
            <p>
                When you use KNEWTODAY, a small cookie in your browser stores an anonymous session ID. On our
                server, we keep the corresponding session data (such as your login status) in a secure database
                table. The cookie itself does not contain your password or full account details — it only lets the
                site match you to the correct session record on the server.
            </p>
            <p>
                This is a standard way modern web applications handle login and security.
            </p>
        </section>

        {{-- Controlling cookies --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">
                5. How you can control cookies
            </h2>
            <p>
                Most browsers allow you to control cookies through their settings. You can:
            </p>
            <ul class="list-disc list-inside space-y-1">
                <li>Delete existing cookies from your device.</li>
                <li>Block cookies from specific sites or all sites.</li>
                <li>Set your browser to notify you before a cookie is stored.</li>
            </ul>
            <p>
                If you choose to block essential cookies, some parts of KNEWTODAY may not work properly, such as
                logging in or staying signed in.
            </p>
        </section>

        {{-- Changes --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">
                6. Updates to this policy
            </h2>
            <p>
                We may update this Cookie Policy from time to time, for example if we start using new types
                of cookies or add third-party services. Any changes will be published on this page with an
                updated “Last updated” date.
            </p>
        </section>

        {{-- Contact --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">
                7. Questions
            </h2>
            <p>
                If you have questions about how cookies are used on KNEWTODAY, you can reach out through the
                <a href="{{ route('front.contact') }}" class="text-kt-accent hover:underline">Contact</a> page.
            </p>
        </section>

    </div>
</main>
@endsection