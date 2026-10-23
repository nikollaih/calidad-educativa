<?php

namespace Tests\Feature;

use App\Http\Resources\UpdatePeiResource;
use App\Models\Institucion;
use App\Models\PeiHistorial;
use App\Models\ResenaHistorica;
use App\Models\RhResenaHistorica;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class HistoricalReviewResourceTest extends TestCase
{
    public function test_historical_review_and_history_snapshots_are_sanitized_for_rendering(): void
    {
        $trace = new PeiHistorial;
        $trace->setAttribute('model_id', 1);
        $trace->setAttribute('model_type', RhResenaHistorica::class);
        $trace->setAttribute('old_data', [
            'resena_historica' => '<p><strong>Anterior</strong><script>alert(1)</script></p>',
        ]);
        $trace->setAttribute('new_data', [
            'resena_historica' => '<p><em>Nuevo</em><img src=x onerror="alert(1)"></p>',
        ]);
        $trace->setAttribute('tipo_codificacion', 2);
        $trace->setAttribute('date', '2026-01-10');
        $trace->setRelation('attachment', null);

        $reviewModel = new RhResenaHistorica;
        $reviewModel->setAttribute('resena_historica', '<p>Actual <script>alert(2)</script></p>');
        $reviewModel->setRelation('historialesPei', new Collection([$trace]));

        $relation = new ResenaHistorica;
        $relation->setRelation('resenaHistorica', $reviewModel);

        $institution = new Institucion;
        $institution->setRelation('resenaHistorica', $relation);

        $resource = (new UpdatePeiResource($institution))->toArray(Request::create('/'));
        $review = $resource['resena_historica']['resena_historica'];
        $history = $review['traces'][0]['changes'];

        $this->assertStringContainsString('<p>Actual', $review['resena_historica']);
        $this->assertStringNotContainsString('<script', $review['resena_historica']);
        $this->assertStringContainsString('<strong>Anterior</strong>', $history['old_data']['resena_historica']);
        $this->assertStringNotContainsString('<script', $history['old_data']['resena_historica']);
        $this->assertStringContainsString('<em>Nuevo</em>', $history['new_data']['resena_historica']);
        $this->assertStringNotContainsString('<img', $history['new_data']['resena_historica']);
        $this->assertStringNotContainsString('onerror', $history['new_data']['resena_historica']);
    }
}
