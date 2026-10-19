<?php

namespace App\Helpers;

use Collator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SelectorOrder
{
    public static function requestedByName(Request $request): bool
    {
        return $request->query('sort') === 'nombre';
    }

    public static function sortIfRequested(iterable $items, Request $request, callable $getLabel): iterable
    {
        return self::requestedByName($request) ? self::sort($items, $getLabel) : $items;
    }

    /**
     * Ordena opciones por etiqueta, agrupando primero las que inician con mayúscula.
     */
    public static function sort(iterable $items, callable $getLabel): Collection
    {
        $collator = class_exists(Collator::class) ? Collator::create('es') : null;

        if ($collator) {
            $collator->setAttribute(Collator::CASE_FIRST, Collator::UPPER_FIRST);
            $collator->setAttribute(Collator::NUMERIC_COLLATION, Collator::ON);
            $collator->setAttribute(Collator::NORMALIZATION_MODE, Collator::ON);
        }

        return collect($items)
            ->values()
            ->map(fn ($item, $index) => ['item' => $item, 'index' => $index])
            ->sort(function (array $left, array $right) use ($getLabel, $collator): int {
                $leftLabel = (string) ($getLabel($left['item']) ?? '');
                $rightLabel = (string) ($getLabel($right['item']) ?? '');

                $rankDifference = self::uppercaseRank($leftLabel) - self::uppercaseRank($rightLabel);
                if ($rankDifference !== 0) {
                    return $rankDifference;
                }

                $comparison = $collator
                    ? $collator->compare($leftLabel, $rightLabel)
                    : strnatcasecmp($leftLabel, $rightLabel);

                return $comparison !== 0 ? $comparison : $left['index'] <=> $right['index'];
            })
            ->pluck('item')
            ->values();
    }

    private static function uppercaseRank(string $text): int
    {
        $firstCharacter = mb_substr($text, 0, 1, 'UTF-8');
        if ($firstCharacter === '') {
            return 0;
        }

        $upper = mb_strtoupper($firstCharacter, 'UTF-8');
        $lower = mb_strtolower($firstCharacter, 'UTF-8');

        if ($upper === $lower) {
            return 0;
        }

        return $firstCharacter === $upper ? 0 : 1;
    }
}
