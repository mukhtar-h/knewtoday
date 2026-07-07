<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Support\HtmlString;

class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'a',
        'b',
        'blockquote',
        'br',
        'div',
        'em',
        'h1',
        'li',
        'ol',
        'p',
        'pre',
        'strong',
        'ul',
    ];

    public static function trix(?string $html): HtmlString
    {
        $html = trim((string) $html);

        if ($html === '') {
            return new HtmlString('');
        }

        if (! class_exists(DOMDocument::class)) {
            return new HtmlString(nl2br(e(strip_tags($html))));
        }

        $document = new DOMDocument;
        $previousLibxmlState = libxml_use_internal_errors(true);

        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="kt-sanitizer-root">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousLibxmlState);

        $root = $document->getElementById('kt-sanitizer-root');

        if (! $root) {
            return new HtmlString('');
        }

        self::sanitizeChildren($root);

        return new HtmlString(self::innerHtml($root));
    }

    private static function sanitizeChildren(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tagName = strtolower($child->tagName);

                if (! in_array($tagName, self::ALLOWED_TAGS, true)) {
                    self::unwrapNode($child);

                    continue;
                }

                self::sanitizeElementAttributes($child);
            }

            if ($child->parentNode) {
                self::sanitizeChildren($child);
            }
        }
    }

    private static function sanitizeElementAttributes(DOMElement $element): void
    {
        $tagName = strtolower($element->tagName);

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $attributeName = strtolower($attribute->nodeName);

            if ($tagName === 'a' && $attributeName === 'href' && self::isSafeUrl($attribute->nodeValue)) {
                continue;
            }

            $element->removeAttributeNode($attribute);
        }
    }

    private static function isSafeUrl(string $url): bool
    {
        $url = trim($url);

        if (preg_match('/[\x00-\x1F\x7F]/', $url)) {
            return false;
        }

        if ($url === '' || str_starts_with($url, '#') || str_starts_with($url, '/')) {
            return true;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);

        return $scheme === null || in_array(strtolower($scheme), ['http', 'https', 'mailto', 'tel'], true);
    }

    private static function unwrapNode(DOMNode $node): void
    {
        $parent = $node->parentNode;

        if (! $parent) {
            return;
        }

        while ($node->firstChild) {
            $parent->insertBefore($node->firstChild, $node);
        }

        $parent->removeChild($node);
    }

    private static function innerHtml(DOMNode $node): string
    {
        $html = '';

        foreach ($node->childNodes as $child) {
            $html .= $node->ownerDocument?->saveHTML($child) ?: '';
        }

        return $html;
    }
}
