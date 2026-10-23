<?php

namespace Tests\Unit;

use App\Services\RichTextSanitizer;
use PHPUnit\Framework\TestCase;

class RichTextSanitizerTest extends TestCase
{
    public function test_it_preserves_supported_formatting_and_removes_active_content(): void
    {
        $sanitizer = new RichTextSanitizer;

        $cleanHtml = $sanitizer->sanitize(
            '<h2>Historia</h2><p><strong>Texto</strong><script>alert(1)</script>'
            .'<img src=x onerror="alert(2)"><a href="https://example.com">enlace</a></p>'
        );

        $this->assertStringContainsString('<h2>Historia</h2>', $cleanHtml);
        $this->assertStringContainsString('<strong>Texto</strong>', $cleanHtml);
        $this->assertStringContainsString('href="https://example.com"', $cleanHtml);
        $this->assertStringNotContainsString('<script', strtolower($cleanHtml));
        $this->assertStringNotContainsString('<img', strtolower($cleanHtml));
        $this->assertStringNotContainsString('onerror', strtolower($cleanHtml));
    }

    public function test_it_rejects_unsafe_link_schemes(): void
    {
        $cleanHtml = (new RichTextSanitizer)->sanitize(
            '<p><a href="javascript:alert(1)">enlace inseguro</a></p>'
        );

        $this->assertStringNotContainsString('javascript:', strtolower($cleanHtml));
        $this->assertStringContainsString('enlace inseguro', $cleanHtml);
    }

    public function test_it_preserves_extended_editor_formats_but_filters_unsafe_styles(): void
    {
        $cleanHtml = (new RichTextSanitizer)->sanitize(
            '<h1 style="text-align:center">Título</h1>'
            .'<p><sub>sub</sub> <sup>sup</sup> <mark data-color="#fef08a" style="background-color:#fef08a">resaltado</mark>'
            .'<span style="color:#1d4ed8;font-size:24px;font-family:Georgia,serif;background-image:url(javascript:alert(1))">estilo</span></p>'
            .'<table style="min-width:75px"><colgroup><col style="min-width:25px"></colgroup>'
            .'<tbody><tr><th scope="col">A</th><td colspan="1">B</td></tr></tbody></table>'
            .'<pre><code>código</code></pre><hr>'
        );

        $this->assertStringContainsString('<h1', $cleanHtml);
        $this->assertStringContainsString('<sub>sub</sub>', $cleanHtml);
        $this->assertStringContainsString('<sup>sup</sup>', $cleanHtml);
        $this->assertStringContainsString('<mark', $cleanHtml);
        $this->assertStringContainsString('<table style="min-width:75px;">', $cleanHtml);
        $this->assertStringContainsString('<colgroup>', $cleanHtml);
        $this->assertStringContainsString('min-width:75px', $cleanHtml);
        $this->assertStringContainsString('<pre><code>código</code></pre>', $cleanHtml);
        $this->assertStringContainsString('<hr', $cleanHtml);
        $this->assertStringNotContainsString('background-image', $cleanHtml);
        $this->assertStringNotContainsString('javascript:', strtolower($cleanHtml));
    }

    public function test_empty_editor_markup_is_normalized_to_an_empty_string(): void
    {
        $this->assertSame('', (new RichTextSanitizer)->sanitize('<p><br></p>'));
        $this->assertSame('', (new RichTextSanitizer)->sanitize(null));
    }

    public function test_plain_text_length_ignores_markup_and_decodes_entities(): void
    {
        $length = (new RichTextSanitizer)->plainTextLength('<p>á &amp; ñ</p>');

        $this->assertSame(5, $length);
        $this->assertSame(5, (new RichTextSanitizer)->plainTextLength('<p>ab<br>cd</p>'));
    }
}
