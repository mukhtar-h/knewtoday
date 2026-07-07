<?php

use App\Support\HtmlSanitizer;

test('trix sanitizer removes scripts and unsafe attributes', function () {
    $html = HtmlSanitizer::trix(
        '<p onclick="alert(1)">Safe</p><script>alert(1)</script><a href="javascript:alert(1)" style="color:red">bad link</a>'
    )->toHtml();

    expect($html)
        ->toContain('<p>Safe</p>')
        ->toContain('<a>bad link</a>')
        ->not->toContain('<script')
        ->not->toContain('onclick')
        ->not->toContain('javascript:')
        ->not->toContain('style=');
});

test('trix sanitizer keeps safe links', function () {
    $html = HtmlSanitizer::trix('<a href="https://example.com/path">safe link</a>')->toHtml();

    expect($html)->toContain('<a href="https://example.com/path">safe link</a>');
});
