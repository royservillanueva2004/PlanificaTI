<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pest;
use App\Models\AnalisisFoda;
use App\Models\PlanEstrategico;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;

class PestController extends Controller
{
    public function index()
    {
        $planId = session('plan_id');

        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Debe seleccionar un plan estratégico.');
        }

        $registro = Pest::where('plan_id', $planId)->first();

        // Nombres amigables de preguntas agrupadas
        $preguntas = [
            // Sociales
            '1' => 'Los cambios en la composicón étnica de los consumidores de nuestro mercado está teniendo un notable impacto.',
            '2' => 'El envejecimiento de la población tiene un importante impacto en la demanda.',
            '3' => 'Los nuevos estilos de vida y tendencias originan cambios en la oferta de nuestro sector.',
            '4' => 'El envejecimiento de la población tiene un importante impacto en la oferta del sector donde operamos.',
            '5' => 'Las variaciones en el nivel de riqueza de la población impactan considerablemente en la demanda de los productos/servicios del sector donde operamos.',
        
            //Ambientales
            '6' => 'La legislación fiscal afecta muy considerablemente a la economía de las empresas del sector donde operamos.',
            '7' => 'La legislación laboral afecta muy considerablemente a la operativa del sector donde actuamos.',

            // Políticos
            '8' => 'Las subvenciones otorgadas por las Administraciones Públicas son claves en el desarrollo competitivo del mercado donde operamos.',
            '9' => 'El impacto que tiene la legislación de protección al consumidor, en la manera de producir bienes y/o servicios es muy importante. ',
            '10' => 'La normativa autonómica tiene un impacto considerable en el funcionamiento del sector donde actuamos.',
            '11' => 'Las expectativas de crecimiento económico generales afectan crucialmente al mercado donde operamos.',
            '12' => 'La política de tipos de interés es fundamental en el desarrollo financiero del sector donde trabaja nuestra empresa.',
            

            // Económicos
            '13' => 'La globalización permite a nuestra industria gozar de importantes oportunidades en  nuevos mercados.',
            '14' => 'La situación del empleo es fundamental para el desarrollo económico de nuestra empresa y nuestro sector.',
            '15' => 'Las expectativas del ciclo económico de nuestro sector impactan en la situación económica de sus empresas.',
            '16' => 'Las Administraciones Públicas están incentivando el esfuerzo tecnológico de las empresas de nuestro sector.',
            '17' => 'Internet, el comercio electrónico, el wireless y otras NTIC están impactando en la demanda de nuestros productos/servicios y en los de la competencia.',
            '18' => 'El empleo de NTIC´s es generalizado en el sector donde trabajamos.',

            // Tecnológicos
            '19' => 'En nuestro sector, es de gran importancia ser pionero o referente en el empleo de aplicaciones tecnológicas.',
            '20' => 'En el sector donde operamos, para ser competitivos, es condición "sine qua non" innovar constantemente.',
            '21' => 'La legislación medioambiental afecta al desarrollo de nuestro sector.',
            '22' => 'Los clientes de nuestro mercado exigen que se seamos socialmente responsables, en el plano medioambiental.',
            '23' => 'En nuestro sector, la políticas medioambientales son una fuente de ventajas competitivas.',
            '24' => 'La creciente preocupación social por el medio ambiente impacta notablemente en la demanda de productos/servicios ofertados en nuestro mercado.',
            '25' => 'El factor ecológico es una fuente de diferenciación clara en el sector donde opera nuestra empresa.',
        ];

        return view('pest.index', compact('preguntas', 'registro'));
    }

    public function generarReflexion(Request $request)
    {
        $valores = $request->input('valores');

        $umbral = 70;
        $conclusiones = [];

        Log::info('Valores recibidos:', $valores); // ✅ LOG 1

        foreach ($valores as $factor => $valor) {
            $valorOriginal = $valor;
            $valor = (int) trim($valor);

            Log::info("Evaluando factor: $factor | Original: $valorOriginal | Convertido: $valor"); // ✅ LOG 2

            if ($valor >= $umbral) {
                $conclusiones[] = "HAY UN NOTABLE IMPACTO DEL FACTOR " . strtoupper($factor) . " EN EL FUNCIONAMIENTO DE LA EMPRESA";
            } else {
                $conclusiones[] = "NO HAY UN NOTABLE IMPACTO DEL FACTOR " . strtoupper($factor) . " EN EL FUNCIONAMIENTO DE LA EMPRESA";
            }
        }

        return response()->json([
            'reflexion' => implode("\n", $conclusiones)
        ]);
    }

    public function mostrarResultado(Request $request)
    {
        $planId = session('plan_id');
        if (!$planId) {
            return redirect()->route('planes.index')->with('error', 'Debe seleccionar un plan estratégico.');
        }

        $respuestas = $request->input('respuestas', []);
        $reflexion = $request->input('reflexion');

        // Agrupación lógica
        $sociales = [
            '1', '2', '3',
            '4', '5'
        ];

        $ambientales = [
            '21', '22',
            '23', '24',
            '25'
        ];

        $politicos = [
            '6', '7',
            '8', '9',
            '10'
        ];

        $economicos = [
            '11', '12', '13',
            '14', '15'
        ];

        $tecnologicos = [
            '16', '17', '18',
            '19', '20'
        ];

        $calcular = fn(array $grupo) => round(array_sum(array_map(fn($k) => $respuestas[$k] ?? 0, $grupo)) / 20 * 100);

        $valores = [
            'social' => $calcular($sociales),
            'ambiental' => $calcular($ambientales),
            'politico' => $calcular($politicos),
            'economico' => $calcular($economicos),
            'tecnologico' => $calcular($tecnologicos),
        ];

        // Guardar análisis
        Pest::updateOrCreate(
            ['plan_id' => $planId],
            [
                'social' => $valores['social'],
                'ambiental' => $valores['ambiental'],
                'politico' => $valores['politico'],
                'economico' => $valores['economico'],
                'tecnologico' => $valores['tecnologico'],
                'conclusion' => $reflexion,
                'respuestas' => $respuestas
            ]
        );

        // Obtener FODA
        $foda = AnalisisFoda::firstOrNew(['plan_id' => $planId]);

        return view('pest.resultado', [
            'valores' => $valores,
            'reflexion' => $reflexion,
            'foda' => $foda
        ]);
    }

    public function guardarFoda(Request $request)
    {
        $planId = session('plan_id');

        $request->validate([
            'oportunidades' => 'nullable|array',
            'amenazas' => 'nullable|array',
        ]);

        $foda = AnalisisFoda::firstOrNew(['plan_id' => $planId]);

        // Normalizar, filtrar vacíos y quitar duplicados
        $oportunidades = collect($request->input('oportunidades', []))
            ->map(fn($o) => trim($o))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $amenazas = collect($request->input('amenazas', []))
            ->map(fn($a) => trim($a))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $foda->oportunidades = $oportunidades;
        $foda->amenazas = $amenazas;
        $foda->save();

        return response()->json(['success' => true]);
    }

    public function verResultado()
    {
        $planId = session('plan_id');

        $registro = Pest::where('plan_id', $planId)->first();
        $foda = AnalisisFoda::where('plan_id', $planId)->first();

        if (!$registro) return redirect()->route('pest.index');

        $valores = [
            'social' => $registro->social,
            'ambiental' => $registro->ambiental,
            'politico' => $registro->politico,
            'economico' => $registro->economico,
            'tecnologico' => $registro->tecnologico,
        ];

        return view('pest.resultado', [
            'valores' => $valores,
            'reflexion' => $registro->conclusion,
            'foda' => $foda
        ]);
    }
    public function generarReflexionDesdeBD()
{
    $planId = session('plan_id');
    if (!$planId) {
        return response()->json(['error' => 'Plan no seleccionado.'], 400);
    }

    $registro = Pest::where('plan_id', $planId)->first();

    if (!$registro) {
        return response()->json(['error' => 'No se encontró el análisis PEST.'], 404);
    }

    $valores = [
        'social' => (int) $registro->social,
        'ambiental' => (int) $registro->ambiental,
        'politico' => (int) $registro->politico,
        'economico' => (int) $registro->economico,
        'tecnologico' => (int) $registro->tecnologico,
    ];

    $umbral = 70;
    $conclusiones = [];

    foreach ($valores as $factor => $valor) {
        if ($valor >= $umbral) {
            $conclusiones[] = "HAY UN NOTABLE IMPACTO DEL FACTOR " . strtoupper($factor) . " EN EL FUNCIONAMIENTO DE LA EMPRESA";
        } else {
            $conclusiones[] = "NO HAY UN NOTABLE IMPACTO DEL FACTOR " . strtoupper($factor) . " EN EL FUNCIONAMIENTO DE LA EMPRESA";
        }
    }

    return response()->json([
        'valores' => $valores,
        'reflexion' => implode("\n", $conclusiones)
    ]);
}
}
