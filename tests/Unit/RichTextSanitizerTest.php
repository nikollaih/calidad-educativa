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
