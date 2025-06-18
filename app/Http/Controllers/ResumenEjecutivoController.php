<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanEstrategico;
use App\Models\ResumenEjecutivo;
use App\Models\Objetivo;
use App\Models\AnalisisFoda;
use Illuminate\Support\Facades\Session;
use OpenAI\Laravel\Facades\OpenAI;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumenEjecutivoController extends Controller
{
    public function index()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::firstOrNew(['plan_id' => $plan_id]);

        return view('resumen-ejecutivo.index', compact('plan', 'resumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'promotores' => 'required|string|max:255',
            'conclusiones' => 'nullable|string',
        ]);

        $plan_id = session('plan_id');

        ResumenEjecutivo::updateOrCreate(
            ['plan_id' => $plan_id],
            [
                'promotores' => $request->promotores,
                'conclusiones' => $request->conclusiones
            ]
        );

        return redirect()->route('resumen-ejecutivo.mostrar')->with('success', 'Resumen guardado.');
    }

    public function mostrar()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::where('plan_id', $plan_id)->first();
        $registroFoda = AnalisisFoda::where('plan_id', $plan_id)->first();

        // ✅ Decodificar directamente los textos en formato JSON
        $foda = [
            'fortaleza'   => $registroFoda->fortalezas ?? [],
            'debilidad'   => $registroFoda->debilidades ?? [],
            'oportunidad' => $registroFoda->oportunidades ?? [],
            'amenaza'     => $registroFoda->amenazas ?? [],
        ];

        // ✅ Cargar objetivos generales con sus objetivos específicos
        $objetivosGenerales = Objetivo::with('especificos')
            ->where('plan_id', $plan_id)
            ->where('tipo', 'general')
            ->get();

        $matrizCame = \App\Models\MatrizCAME::where('plan_id', $plan->id)->get();
        return view('resumen-ejecutivo.mostrar', compact('plan', 'resumen', 'foda', 'objetivosGenerales', 'matrizCame'));
    }

    public function generarEstrategia()
    {
        $plan_id = session('plan_id');
        $registroFoda = AnalisisFoda::where('plan_id', $plan_id)->first();

        if (!$registroFoda) {
            return response()->json(['error' => 'No se encontró análisis FODA.'], 404);
        }

        $prompt = <<<EOT
        Eres un experto en planificación estratégica en el ámbito de Tecnologías de la Información (TI).

        A partir del siguiente análisis FODA de una empresa, redacta una estrategia enfocada en el uso de TI que:
        - Aproveche las fortalezas para consolidar ventajas tecnológicas.
        - Potencie las oportunidades del entorno digital.
        - Reduzca las debilidades relacionadas con la infraestructura o habilidades tecnológicas.
        - Afronte las amenazas del entorno competitivo y tecnológico.

        La estrategia debe ser concreta, orientada a la transformación digital, automatización, innovación y mejora continua en los procesos de TI.

        ANÁLISIS FODA:

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

        ResumenEjecutivo::updateOrCreate(
            ['plan_id' => $plan_id],
            ['identificacion_estrategica' => $estrategia]
        );
        return response()->json(['estrategia' => $estrategia]);
    }

    private function formatearLista($items)
    {
        if (is_array($items)) {
            return implode("\n- ", array_map('trim', $items));
        }

        return '- ' . trim($items);
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

            // Seguridad mínima
            if (!$registroFoda || $objetivos->isEmpty()) {
                return response()->json(['error' => 'Faltan datos para generar conclusiones.'], 422);
            }

            // Datos para el prompt
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
    Eres un experto en planificación estratégica. Tu tarea es redactar una conclusión clara y profesional que resuma el Plan Estratégico de una empresa del sector tecnológico.

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

    Objetivos Estratégicos:
    {$this->formatearLista($objetivos->pluck('descripcion')->toArray())}

    Estrategia tecnológica generada:
    {$resumen->identificacion_estrategica}

    Acciones CAME:
    - Corregir: {$acciones['Corregir']}
    - Afrontar: {$acciones['Afrontar']}
    - Mantener: {$acciones['Mantener']}
    - Explotar: {$acciones['Explotar']}

    Redacta una conclusión final (máx. 6 líneas) que sintetice los hallazgos y enfoques estratégicos del plan.
    EOT;

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un experto en planificación estratégica'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $conclusion = $response['choices'][0]['message']['content'] ?? 'No se pudo generar la conclusión.';

            // Guardar en BD
            $resumen->update(['conclusiones' => $conclusion]);

            return response()->json(['conclusion' => $conclusion]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno: ' . $e->getMessage()], 500);
        }
    }

    public function generarPDF()
    {
        $plan_id = session('plan_id');
        $plan = PlanEstrategico::findOrFail($plan_id);
        $resumen = ResumenEjecutivo::where('plan_id', $plan_id)->first();
        $registroFoda = AnalisisFoda::where('plan_id', $plan_id)->first();
        $objetivos = Objetivo::with('especificos')->where('plan_id', $plan_id)->where('tipo', 'general')->get();
        $matrizCame = \App\Models\MatrizCAME::where('plan_id', $plan_id)->get();

        $foda = [
            'fortaleza'   => $registroFoda->fortalezas ?? [],
            'debilidad'   => $registroFoda->debilidades ?? [],
            'oportunidad' => $registroFoda->oportunidades ?? [],
            'amenaza'     => $registroFoda->amenazas ?? [],
        ];

        $pdf = Pdf::loadView('resumen-ejecutivo.pdf', compact('plan', 'resumen', 'foda', 'objetivos', 'matrizCame'));
        return $pdf->download('resumen-ejecutivo.pdf');
    }

}
