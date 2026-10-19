<?php

namespace Tests\Unit;

use App\Helpers\SelectorOrder;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class SelectorOrderTest extends TestCase
{
    public function test_uppercase_initials_are_grouped_before_lowercase_initials(): void
    {
        $options = ['beta', 'Beto', 'alfa', 'Alpha'];

        $sorted = SelectorOrder::sort($options, fn (string $option) => $option);

        $this->assertSame(['Alpha', 'Beto', 'alfa', 'beta'], $sorted->all());
    }

    public function test_numeric_segments_are_sorted_naturally(): void
    {
        $options = ['Fase 10', 'Fase 2', 'Fase 1'];

        $sorted = SelectorOrder::sort($options, fn (string $option) => $option);

        $this->assertSame(['Fase 1', 'Fase 2', 'Fase 10'], $sorted->all());
    }

    public function test_selector_sort_query_parameter_is_explicit(): void
    {
        $request = Request::create('/options?sort=nombre&direction=asc');
        $options = ['beta', 'Alpha'];

        $sorted = SelectorOrder::sortIfRequested($options, $request, fn (string $option) => $option);

        $this->assertSame(['Alpha', 'beta'], $sorted->all());
    }
}
