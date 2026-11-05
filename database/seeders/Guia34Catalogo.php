<?php

namespace Database\Seeders;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use RuntimeException;

/**
 * Extracts seed data from the cell values in guia34.html.
 * Text is not rewritten or paraphrased; numeric codes are stored separately
 * from their display labels, as they are in the existing database schema.
 */
final class Guia34Catalogo
{
    /** @var array<string, mixed>|null */
    private static ?array $cache = null;

    /**
     * @return array{
     *     procesos: array<string, array{padre_indice: string, nombre: string}>,
     *     componentes: array<int, array{
     *         indice: string,
     *         grupo_indice: string,
     *         nombre: string,
     *         notas: array<int, string>,
     *         factores: array<int, array{descripcion: string, objetivo: string, meta: string}>
     *     }>
     * }
     */
    public static function cargar(?string $ruta = null): array
    {
        $usarCache = $ruta === null;

        if ($usarCache && self::$cache !== null) {
            return self::$cache;
        }

        $ruta ??= base_path('guia34.html');

        if (! is_file($ruta)) {
            throw new RuntimeException("No se encontró el archivo guía requerido: {$ruta}");
        }

        $documento = new DOMDocument('1.0', 'UTF-8');
        $erroresAnteriores = libxml_use_internal_errors(true);
        $cargado = $documento->loadHTMLFile($ruta, LIBXML_NONET | LIBXML_NOWARNING | LIBXML_NOERROR);
        libxml_clear_errors();
        libxml_use_internal_errors($erroresAnteriores);

        if (! $cargado) {
            throw new RuntimeException("No fue posible leer el archivo guía: {$ruta}");
        }

        $xpath = new DOMXPath($documento);
        $tablas = $xpath->query('//table');

        if ($tablas === false || $tablas->length !== 4) {
            throw new RuntimeException('La guía debe contener exactamente cuatro tablas de área.');
        }

        $procesos = [];
        $componentes = [];

        foreach ($tablas as $indiceTabla => $tabla) {
            if (! $tabla instanceof DOMElement) {
                continue;
            }

            $matriz = self::crearMatriz($tabla);
            $columnaProceso = $indiceTabla < 3 ? 1 : 0;
            $columnaComponente = $indiceTabla < 3 ? 2 : 1;
            $columnaDescriptor = $indiceTabla < 3 ? 3 : 2;
            $columnaFactor = $indiceTabla < 3 ? 7 : 6;
            $columnaObjetivo = $indiceTabla < 3 ? 10 : 9;
            $procesoActual = '';

            // Las primeras tres filas son título y encabezados en las cuatro hojas.
            foreach (array_slice($matriz, 3) as $fila) {
                $textoComponente = $fila[$columnaComponente] ?? '';

                if ($textoComponente === '') {
                    continue;
                }

                $textoProceso = $fila[$columnaProceso] ?? '';
                if ($textoProceso !== '') {
                    $procesoActual = $textoProceso;
                }

                if (! preg_match('/^\s*(\d+\.\d+\.\d+)\s*(.*)$/us', $textoComponente, $coincidenciaComponente)) {
                    throw new RuntimeException('No se pudo extraer el código del componente de la guía.');
                }

                $codigoComponente = $coincidenciaComponente[1];
                $codigoProceso = substr($codigoComponente, 0, strrpos($codigoComponente, '.'));
                $nombreComponente = $coincidenciaComponente[2];

                if (! preg_match('/^\s*(\d+)\s*\.\s*(\d+)\s*(.*)$/us', $procesoActual, $coincidenciaProceso)) {
                    throw new RuntimeException("No se pudo extraer el proceso del componente {$codigoComponente}.");
                }

                $codigoProcesoEnTexto = $coincidenciaProceso[1].'.'.$coincidenciaProceso[2];
                if ($codigoProcesoEnTexto !== $codigoProceso) {
                    throw new RuntimeException("El proceso de {$codigoComponente} no coincide con el código del componente.");
                }

                $nombreProceso = $coincidenciaProceso[3];
                $indicePadre = explode('.', $codigoProceso, 2)[0];

                if (isset($procesos[$codigoProceso]) && $procesos[$codigoProceso]['nombre'] !== $nombreProceso) {
                    throw new RuntimeException("La guía asigna más de un nombre al proceso {$codigoProceso}.");
                }

                $procesos[$codigoProceso] = [
                    'padre_indice' => $indicePadre,
                    'nombre' => $nombreProceso,
                ];

                $notas = [];
                for ($valor = 1; $valor <= 4; $valor++) {
                    $notas[$valor] = $fila[$columnaDescriptor + $valor - 1] ?? '';
                }

                $factores = [];
                for ($valor = 1; $valor <= 3; $valor++) {
                    $factores[$valor] = [
                        'descripcion' => $fila[$columnaFactor + $valor - 1] ?? '',
                        'objetivo' => $fila[$columnaObjetivo + (($valor - 1) * 2)] ?? '',
                        'meta' => $fila[$columnaObjetivo + (($valor - 1) * 2) + 1] ?? '',
                    ];
                }

                foreach ($notas as $valor => $descripcion) {
                    if ($descripcion === '') {
                        throw new RuntimeException("Falta el descriptor de nota {$valor} para {$codigoComponente}.");
                    }
                }

                foreach ($factores as $valor => $factor) {
                    if ($factor['descripcion'] === '' || $factor['objetivo'] === '' || $factor['meta'] === '') {
                        throw new RuntimeException("Falta factor, objetivo o meta de nivel {$valor} para {$codigoComponente}.");
                    }
                }

                $componentes[] = [
                    'indice' => $codigoComponente,
                    'grupo_indice' => $codigoProceso,
                    'nombre' => $nombreComponente,
                    'notas' => $notas,
                    'factores' => $factores,
                ];
            }
        }

        if (count($procesos) !== 15 || count($componentes) !== 45) {
            throw new RuntimeException(sprintf(
                'La guía produjo %d procesos y %d componentes; se esperaban 15 y 45.',
                count($procesos),
                count($componentes)
            ));
        }

        $resultado = [
            'procesos' => $procesos,
            'componentes' => $componentes,
        ];

        if ($usarCache) {
            self::$cache = $resultado;
        }

        return $resultado;
    }

    /** @return array<int, array<int, string>> */
    private static function crearMatriz(DOMElement $tabla): array
    {
        $xpath = new DOMXPath($tabla->ownerDocument);
        $filas = $xpath->query('./tr | ./thead/tr | ./tbody/tr | ./tfoot/tr', $tabla);

        if ($filas === false) {
            throw new RuntimeException('No se pudieron leer las filas de una tabla de la guía.');
        }

        $matriz = [];

        foreach ($filas as $indiceFila => $fila) {
            $celdas = $xpath->query('./td | ./th', $fila);
            if ($celdas === false) {
                continue;
            }

            $columna = 0;
            foreach ($celdas as $celda) {
                if (! $celda instanceof DOMElement) {
                    continue;
                }

                while (array_key_exists($columna, $matriz[$indiceFila] ?? [])) {
                    $columna++;
                }

                $texto = self::valorCelda($celda);
                $columnas = max(1, (int) ($celda->getAttribute('colspan') ?: 1));
                $filasOcupadas = max(1, (int) ($celda->getAttribute('rowspan') ?: 1));

                for ($desfaseFila = 0; $desfaseFila < $filasOcupadas; $desfaseFila++) {
                    for ($desfaseColumna = 0; $desfaseColumna < $columnas; $desfaseColumna++) {
                        $matriz[$indiceFila + $desfaseFila][$columna + $desfaseColumna] =
                            $desfaseFila === 0 && $desfaseColumna === 0 ? $texto : '';
                    }
                }

                $columna += $columnas;
            }
        }

        ksort($matriz);
        foreach ($matriz as &$fila) {
            ksort($fila);
            if ($fila !== []) {
                $fila = array_replace(array_fill(0, max(array_keys($fila)) + 1, ''), $fila);
            }
        }
        unset($fila);

        return array_values($matriz);
    }

    private static function valorCelda(DOMElement $celda): string
    {
        $valor = $celda->getAttribute('data-sheets-value');

        if ($valor !== '') {
            try {
                $contenido = json_decode($valor, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $exception) {
                throw new RuntimeException('Una celda de guia34.html tiene un valor de origen inválido.', 0, $exception);
            }

            if (! is_array($contenido) || ! array_key_exists(2, $contenido)) {
                throw new RuntimeException('Una celda de guia34.html no contiene el valor textual esperado.');
            }

            return (string) $contenido[2];
        }

        $texto = '';
        foreach ($celda->childNodes as $nodo) {
            $texto .= self::textoNodo($nodo);
        }

        return $texto;
    }

    private static function textoNodo(DOMNode $nodo): string
    {
        if ($nodo instanceof DOMElement && strtolower($nodo->tagName) === 'br') {
            return "\n";
        }

        if (! $nodo->hasChildNodes()) {
            return $nodo->textContent ?? '';
        }

        $texto = '';
        foreach ($nodo->childNodes as $hijo) {
            $texto .= self::textoNodo($hijo);
        }

        return $texto;
    }
}
