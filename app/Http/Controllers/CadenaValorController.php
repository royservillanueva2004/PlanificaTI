<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanEstrategico;
use App\Models\CadenaValor;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\AnalisisFoda;

class CadenaValorController extends Controller
{
    public function index()
    {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Debe seleccionar un plan estratégico.');
        }

        $registro = CadenaValor::where('plan_id', $planId)->first();

        $preguntas = [
            "La empresa tiene una política sistematizada de cero defectos en la producción de productos/servicios.",
            "La empresa emplea los medios productivos tecnológicamente más avanzados de su sector.",
            "La empresa dispone de un sistema de información y control de gestión eficiente y eficaz.",
            "Los medios técnicos y tecnológicos de la empresa están preparados para competir en un futuro a corto, medio y largo plazo.",
            "La empresa es un referente en su sector en I+D+i.",
            "La excelencia de los procedimientos de la empresa (en ISO, etc.) son una principal fuente de ventaja competitiva.",
            "La empresa dispone de página web, y esta se emplea no sólo como escaparate sino como canal estratégico.",
            "Los productos/servicios desarrollados llevan incorporada tecnología difícil de imitar.",
            "La empresa es referente en su sector en optimización de la cadena de producción.",
            "La informatización de la empresa representa una ventaja competitiva clara.",
            "Los canales de distribución de la empresa son una fuente de ventajas competitivas.",
            "Los productos/servicios son altamente valorados por nuestros clientes.",
            "La empresa ejecuta un sistemático plan de marketing y ventas.",
            "La gestión financiera de la empresa está optimizada.",
            "Se mejora continuamente la relación con los clientes desde un plan previo.",
            "La empresa lanza productos innovadores con éxito comprobado.",
            "El capital humano es considerado activo estratégico clave.",
            "La plantilla está motivada y conoce claramente los objetivos organizacionales.",
            "La empresa trabaja con estrategia y objetivos definidos.",
            "La gestión del circulante está optimizada.",
            "El posicionamiento estratégico de los productos está claramente definido.",
            "Existe una política de marca basada en reputación y relación cliente.",
            "La cartera de clientes está altamente fidelizada.",
            "Ventas y marketing son una ventaja competitiva clave.",
            "El servicio al cliente representa una ventaja frente a la competencia.",
        ];
        
        $porcentajeMejora = null;
        if ($registro && is_array($registro->respuestas)) {
            $total = array_sum($registro->respuestas);
            $porcentajeMejora = round((1 - ($total / 100)) * 100);
        }

        return view('cadena-valor.index', [
            'preguntas' => $preguntas,
            'registro' => $registro,
            'porcentajeMejora' => $porcentajeMejora, // ✅ Aquí se pasa a la vista
        ]);
    }

    public function store(Request $request)
    {
        $planId = session('plan_id');

        $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*' => 'nullable|in:0,1,2,3,4',
            'reflexion' => 'nullable|string'
        ]);

        CadenaValor::updateOrCreate(
            ['plan_id' => $planId],
            [
                'respuestas' => $request->respuestas,
                'reflexion' => $request->reflexion
            ]
        );

        return redirect()->back()->with('success', 'Autoevaluación guardada correctamente.');
    }

    public function generarReflexion(Request $request)
    {
        $resultado = $request->input('resultado');

        $prompt = "Genera una reflexión estratégica basada en un POTENCIAL DE MEJORA del " . (100 - $resultado) . "% en una autoevaluación de la cadena de valor. " .
                "La reflexión debe enfocarse en identificar áreas clave de mejora, visión estratégica y oportunidades sin mencionar puntuaciones explícitas. " .
                "No excedas 15 líneas en el texto.";

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo', // opcionalmente más rápido que gpt-4
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un asesor experto en planeamiento estratégico.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 600, // Aproximadamente 15 líneas
        ]);

        return response()->json([
            'reflexion' => $response['choices'][0]['message']['content'] ?? 'No se pudo generar la reflexión.'
        ]);
    }

    public function mostrarAnalisis(Request $request)
    {
        $planId = session('plan_id');

        // Guardar la evaluación
        CadenaValor::updateOrCreate(
            ['plan_id' => $planId],
            [
                'respuestas' => $request->respuestas,
                'reflexion' => $request->reflexion
            ]
        );

        // Recuperar fortalezas y debilidades guardadas (si existen)
        $foda = AnalisisFoda::where('plan_id', $planId)->first();

        $total = array_sum($request->respuestas ?? []);
        $porcentajeMejora = round((1 - ($total / 100)) * 100);

        return view('cadena-valor.analisis', [
            'resultado' => 100 - $porcentajeMejora,
            'reflexion' => $request->reflexion,
            'foda' => $foda
        ]);
    }
    
    public function verAnalisis()
    {
        $planId = session('plan_id');
        $registro = CadenaValor::where('plan_id', $planId)->first();
        $foda = AnalisisFoda::where('plan_id', $planId)->first();

        if (!$registro) return redirect()->route('cadena-valor.index');

        $total = array_sum($registro->respuestas ?? []);
        $porcentajeMejora = round((1 - ($total / 100)) * 100);

        return view('cadena-valor.analisis', [
            'resultado' => 100 - $porcentajeMejora,
            'reflexion' => $registro->reflexion,
            'foda' => $foda
        ]);
    }
}
