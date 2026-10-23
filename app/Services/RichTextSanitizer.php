<?php

namespace App\Services;

/**
 * Sanitiza el HTML de texto enriquecido antes de persistirlo o renderizarlo.
 *
 * La lista permitida coincide con los formatos habilitados en RichTextEditor.
 */
class RichTextSanitizer
{
    private ?\HTMLPurifier $purifier = null;

    public function sanitize(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $sanitizedHtml = $this->purifier()->purify($html);
        $textWithoutLineBreaks = str_replace(["\r", "\n"], '', $this->plainText($sanitizedHtml));

        // El editor puede enviar párrafos vacíos cuando se borra todo el contenido.
        if (trim($textWithoutLineBreaks) === '') {
            return '';
        }

        return $sanitizedHtml;
    }

    /** Cuenta caracteres de texto, no etiquetas ni atributos HTML. */
    public function plainTextLength(string $sanitizedHtml): int
    {
        return mb_strlen($this->plainText($sanitizedHtml), 'UTF-8');
    }

    private function plainText(string $sanitizedHtml): string
    {
        $withLineBreaks = preg_replace('/<br\b[^>]*\/?>/i', "\n", $sanitizedHtml) ?? $sanitizedHtml;
        $plainText = html_entity_decode(strip_tags($withLineBreaks), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plainText = preg_replace('/[\x{00A0}\x{200B}]/u', ' ', $plainText) ?? $plainText;

        return $plainText;
    }

    private function purifier(): \HTMLPurifier
    {
        if ($this->purifier !== null) {
            return $this->purifier;
        }

        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'UTF-8');
        $config->set(
            'HTML.Allowed',
            'p,br,strong,b,em,i,u,s,del,ol,ul,li,h1,h2,h3,blockquote,a[href|title]'
        );
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
        ]);

        $this->purifier = new \HTMLPurifier($config);

        return $this->purifier;
    }
}
