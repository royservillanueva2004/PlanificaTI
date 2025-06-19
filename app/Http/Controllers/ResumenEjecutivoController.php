<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanEstrategico;
use App\Models\ResumenEjecutivo;
use App\Models\Objetivo;
use App\Models\AnalisisFoda;
use Barryvdh\DomPDF\Facade\Pdf;
use OpenAI\Laravel\Facades\OpenAI;

class ResumenEjecutivoController extends Controller
{
    public function index()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::firstOrCreate(['plan_id' => $plan_id]);

        return view('resumen-ejecutivo.index', compact('plan', 'resumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'promotores' => 'required|string|max:255',
        ]);

        $plan_id = session('plan_id');
        $resumen = ResumenEjecutivo::firstOrCreate(['plan_id' => $plan_id]);

        $resumen->promotores = $request->promotores;

        // Solo actualiza 'conclusiones' si viene en la solicitud
        if ($request->has('conclusiones')) {
            $resumen->conclusiones = $request->conclusiones;
        }

        $resumen->save();

        return redirect()->route('resumen-ejecutivo.mostrar')->with('success', 'Resumen guardado.');
    }

    public function mostrar()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::firstOrCreate(['plan_id' => $plan_id]);
        $registroFoda = AnalisisFoda::where('plan_id', $plan_id)->first();

        $foda = [
            'fortaleza'   => $registroFoda->fortalezas ?? [],
            'debilidad'   => $registroFoda->debilidades ?? [],
            'oportunidad' => $registroFoda->oportunidades ?? [],
            'amenaza'     => $registroFoda->amenazas ?? [],
        ];

        $objetivosGenerales = Objetivo::with('especificos')
            ->where('plan_id', $plan_id)
            ->where('tipo', 'general')
            ->get();

        $matrizCame = \App\Models\MatrizCAME::where('plan_id', $plan->id)->get();
        $uens = \App\Models\Uen::where('plan_id', $plan_id)->get();

        return view('resumen-ejecutivo.mostrar', compact('plan', 'resumen', 'foda', 'objetivosGenerales', 'matrizCame', 'uens'));
    }

    public function generarEstrategia()
    {
        $plan_id = session('plan_id');
        $resumen = ResumenEjecutivo::firstOrCreate(['plan_id' => $plan_id]);
        $registroFoda = AnalisisFoda::where('plan_id', $plan_id)->first();

        if (!$registroFoda) {
            return response()->json(['error' => 'No se encontró análisis FODA.'], 404);
        }

        $prompt = <<<EOT
Eres un experto en planificación estratégica en el ámbito de Tecnologías de la Información (TI).
Redacta una estrategia basada en este FODA:

Fortalezas:
- {$this->formatearLista($registroFoda->fortalezas ?? [])}

Debilidades:
- {$this->formatearLista($registroFoda->debilidades ?? [])}

Oportunidades:
- {$this->formatearLista($registroFoda->oportunidades ?? [])}

Amenazas:
- {$this->formatearLista($registroFoda->amenazas ?? [])}
EOT;

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un experto en planificación estratégica.'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $estrategia = $response['choices'][0]['message']['content'] ?? 'No se pudo generar la estrategia.';
        $resumen->identificacion_estrategica = $estrategia;
        $resumen->save();

        return response()->json(['estrategia' => $estrategia]);
    }

    public function generarConclusiones()
    {
        try {
            $plan_id = session('plan_id');
            $plan = PlanEstrategico::findOrFail($plan_id);
            $resumen = ResumenEjecutivo::firstOrCreate(['plan_id' => $plan_id]);
            $registroFoda = AnalisisFoda::where('plan_id', $plan_id)->first();
            $objetivos = Objetivo::where('plan_id', $plan_id)->where('tipo', 'general')->get();
            $matriz = \App\Models\MatrizCAME::where('plan_id', $plan_id)->get();

            if (!$registroFoda || $objetivos->isEmpty()) {
                return response()->json(['error' => 'Faltan datos para generar conclusiones.'], 422);
            }

            $foda = [
                'Fortalezas' => $this->formatearLista($registroFoda->fortalezas),
                'Debilidades' => $this->formatearLista($registroFoda->debilidades),
                'Oportunidades' => $this->formatearLista($registroFoda->oportunidades),
                'Amenazas' => $this->formatearLista($registroFoda->amenazas),
            ];

            $acciones = [
                'Corregir' => $this->formatearLista($matriz->where('tipo', 'C')->pluck('accion')->toArray()),
                'Afrontar' => $this->formatearLista($matriz->where('tipo', 'A')->pluck('accion')->toArray()),
                'Mantener' => $this->formatearLista($matriz->where('tipo', 'M')->pluck('accion')->toArray()),
                'Explotar' => $this->formatearLista($matriz->where('tipo', 'E')->pluck('accion')->toArray()),
            ];

            $prompt = <<<EOT
Redacta una conclusión final (máx. 6 líneas) que sintetice los hallazgos y enfoques estratégicos del siguiente plan:

Misión: {$plan->mision}
Visión: {$plan->vision}

FODA:
Fortalezas:
{$foda['Fortalezas']}

Debilidades:
{$foda['Debilidades']}

Oportunidades:
{$foda['Oportunidades']}

Amenazas:
{$foda['Amenazas']}

Objetivos:
{$this->formatearLista($objetivos->pluck('descripcion')->toArray())}

Estrategia:
{$resumen->identificacion_estrategica}

CAME:
- Corregir: {$acciones['Corregir']}
- Afrontar: {$acciones['Afrontar']}
- Mantener: {$acciones['Mantener']}
- Explotar: {$acciones['Explotar']}
EOT;

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un experto en planificación estratégica.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $conclusion = $response['choices'][0]['message']['content'] ?? 'No se pudo generar la conclusión.';
            $resumen->conclusiones = $conclusion;
            $resumen->save();

            return response()->json(['conclusion' => $conclusion]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function generarPDF()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::firstOrCreate(['plan_id' => $plan_id]);
        $registroFoda = AnalisisFoda::where('plan_id', $plan_id)->first();
        $objetivos = Objetivo::with('especificos')->where('plan_id', $plan_id)->where('tipo', 'general')->get();
        $matrizCame = \App\Models\MatrizCAME::where('plan_id', $plan_id)->get();
        $uens = \App\Models\Uen::where('plan_id', $plan_id)->get();

        $foda = [
            'fortaleza'   => $registroFoda->fortalezas ?? [],
            'debilidad'   => $registroFoda->debilidades ?? [],
            'oportunidad' => $registroFoda->oportunidades ?? [],
            'amenaza'     => $registroFoda->amenazas ?? [],
        ];

        $pdf = Pdf::loadView('resumen-ejecutivo.pdf', compact('plan', 'resumen', 'foda', 'objetivos', 'matrizCame','uens'));
        return $pdf->download('resumen-ejecutivo.pdf');
    }

    private function formatearLista($items)
    {
        if (is_array($items)) {
            return implode("\n- ", array_map('trim', $items));
        }
        return '- ' . trim($items);
    }
}
