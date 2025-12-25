@extends('layouts.public')

@section('title', 'Privacy Policy — KNEWTODAY')

@section('meta_description', 'Learn how KNEWTODAY collects, uses, and protects your personal information, including email, comments, and site activity.')

@section('content')
<main class="flex-1">
    <div class="max-w-4xl mx-auto px-4 py-10 space-y-10">

        {{-- Header --}}
        <section class="space-y-2">
            <h1 class="kt-section-title">
                Privacy Policy
            </h1>
            <p class="text-sm text-kt-textMuted max-w-2xl">
                This Privacy Policy explains how KNEWTODAY collects, uses, stores, and protects your data
                when you use our website, submit forms, or interact with our content.
            </p>
            <p class="text-[11px] text-kt-muted">
                Last updated: {{ now()->format('F j, Y') }}
            </p>
        </section>

        {{-- Section 1 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">1. Information we collect</h2>

            <p>KNEWTODAY may collect the following types of information:</p>

            <ul class="list-disc list-inside space-y-1">
                <li>
                    <span class="text-kt-text font-semibold">Account information</span>
                    (name, email) — only if you register for an account.
                </li>
                <li>
                    <span class="text-kt-text font-semibold">Newsletter data</span>
                    (email, name if provided).
                </li>
                <li>
                    <span class="text-kt-text font-semibold">Contact form messages</span>
                    (name, email, message).
                </li>
                <li>
                    <span class="text-kt-text font-semibold">Comments</span>
                    including:
                    <ul class="ml-6 list-circle space-y-1">
                        <li>Name and email (if you are a guest commenter)</li>
                        <li>Your comment message</li>
                    </ul>
                </li>
                <li>
                    <span class="text-kt-text font-semibold">Basic technical data</span>
                    such as:
                    <ul class="ml-6 list-circle space-y-1">
                        <li>IP address</li>
                        <li>User agent (device/browser type)</li>
                        <li>Pages visited</li>
                        <li>Time spent on pages</li>
                    </ul>
                </li>
            </ul>

            <p>
                We do not collect sensitive personal information such as your home address,
                payment information, or government ID.
            </p>
        </section>

        {{-- Section 2 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">2. How we use your information</h2>

            <ul class="list-disc list-inside space-y-1">
                <li>To manage user accounts (login, authentication).</li>
                <li>To send newsletters and updates (if you subscribe).</li>
                <li>To respond to contact form messages.</li>
                <li>To publish and manage comments on stories.</li>
                <li>To analyze site performance and prevent abuse or spam.</li>
                <li>To improve storytelling, navigation, and reader experience.</li>
            </ul>

            <p>
                We do not sell your information or share it with advertisers or third-party networks.
            </p>
        </section>

        {{-- Section 3 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">3. Cookies and sessions</h2>

            <p>
                Like most websites, KNEWTODAY uses cookies to keep the site running smoothly. These cookies
                help with login sessions, CSRF protection, and basic functionality.
            </p>

            <p>
                For details about cookies specifically, please see our
                <a href="{{ route('front.cookies') }}" class="text-kt-accent hover:underline">Cookie Policy</a>.
            </p>
        </section>

        {{-- Section 4 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">4. Newsletter</h2>

            <p>
                If you subscribe to our newsletter, we collect your email address (and name if provided) to send
                you updates and new stories. You can unsubscribe at any time using the link provided in each
                email or via:
            </p>

            <p class="text-kt-text font-semibold">
                {{ route('newsletter.unsubscribe.link', ['subscriber' => 'subscriber->id', 'token' => '$subscriber->unsubscribe_token',]) }}
                <span class="text-kt-muted">(example link)</span>
            </p>

            <p>
                We do not share newsletter subscriber information with any third parties.
            </p>
        </section>

        {{-- Section 5 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">5. Comments</h2>

            <p>
                If you leave a comment on a story:
            </p>

            <ul class="list-disc list-inside space-y-1">
                <li>Your name (or chosen alias) is publicly visible.</li>
                <li>Your email is stored privately and never shown publicly.</li>
                <li>Your comment is stored until deleted by you or by moderation.</li>
                <li>Your IP address may be collected to fight spam or abuse.</li>
            </ul>
        </section>

        {{-- Section 6 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">6. How long we keep your data</h2>

            <p>
                We keep information only as long as needed:
            </p>

            <ul class="list-disc list-inside space-y-1">
                <li><span class="font-semibold text-kt-text">Account data:</span> until you delete your account.</li>
                <li><span class="font-semibold text-kt-text">Newsletter data:</span> until you unsubscribe.</li>
                <li><span class="font-semibold text-kt-text">Comments:</span> indefinitely (unless removed).</li>
                <li><span class="font-semibold text-kt-text">Contact messages:</span> typically 6–24 months.</li>
                <li><span class="font-semibold text-kt-text">Logs & security data:</span> short retention as needed for security.</li>
            </ul>
        </section>

        {{-- Section 7 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">7. Security</h2>

            <p>
                We take reasonable technical and organizational measures to protect your information, including:
            </p>

            <ul class="list-disc list-inside space-y-1">
                <li>Encrypted HTTPS connections.</li>
                <li>Hashed and salted passwords.</li>
                <li>Role-based access control (RBAC).</li>
                <li>Database-level protections.</li>
                <li>Spam prevention for comments and forms.</li>
            </ul>

            <p>
                However, no system is 100% secure. If we ever experience a data issue, we will notify affected
                users when required.
            </p>
        </section>

        {{-- Section 8 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">8. Your rights</h2>

            <p>You may request:</p>

            <ul class="list-disc list-inside space-y-1">
                <li>Access to the information we store about you.</li>
                <li>Correction of inaccurate data.</li>
                <li>Deletion of your newsletter subscription.</li>
                <li>Removal of comments you posted.</li>
            </ul>

            <p>
                For any request, reach out through the
                <a href="{{ route('front.contact') }}" class="text-kt-accent hover:underline">Contact page</a>.
            </p>
        </section>

        {{-- Section 9 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">9. Changes to this policy</h2>

            <p>
                We may update this Privacy Policy from time to time. Significant changes will be highlighted on
                this page with an updated “Last updated” date.
            </p>
        </section>

        {{-- Section 10 --}}
        <section class="kt-card space-y-3 text-sm text-kt-textMuted">
            <h2 class="kt-section-title text-base">10. Contact</h2>

            <p>
                If you have any questions about this Privacy Policy or your data, please get in touch through
                the <a href="{{ route('front.contact') }}" class="text-kt-accent hover:underline">Contact</a> page.
            </p>
        </section>

    </div>
</main>
@endsection