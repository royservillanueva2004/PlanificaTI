@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-5">Análisis de PEST</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3 bg-green-500 text-white p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('fuerza_porter.store') }}" id="pestForm">
        @csrf

        <div class="overflow-x-auto shadow-xl sm:rounded-lg mb-5">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left w-1/4">Autodiagnóstico entorno global P.E.S.T.</th>
                        <th class="border border-gray-300 px-2 py-2 text-center">En total desacuerdo<br><small>0 punto</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">No está de acuerdo<br><small>1 punto</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">Está de acuerdo<br><small>2 puntos</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">Está bastante de acuerdo<br><small>3 puntos</small></th>
                        <th class="border border-gray-300 px-2 py-2 text-center">En total acuerdo<br><small>4 puntos</small></th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">1. La legislación fiscal afecta muy considerablemente a la economía de las empresas del sector donde operamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_fiscal" value="0" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_fiscal" value="1" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_fiscal" value="2" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_fiscal" value="3" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_fiscal" value="4" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_politico_legislacion_fiscal">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">2. La legislación laboral afecta muy considerablemente a la operativa del sector donde actuamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_laboral" value="0" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_laboral" value="1" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_laboral" value="2" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_laboral" value="3" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_laboral" value="4" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_politico_legislacion_laboral">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">3. Las subvenciones otorgadas por las Administraciones Públicas son claves en el desarrollo competitivo del mercado donde operamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="politico_subvenciones" value="0" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_subvenciones" value="1" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_subvenciones" value="2" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_subvenciones" value="3" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_subvenciones" value="4" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_politico_subvenciones">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">4. El impacto que tiene la legislación de protección al consumidor, en la manera de producir bienes y/o servicios es muy importante.</td>
                        <td class="border border-gray-300"><input type="radio" name="politico_proteccion_consumidor" value="0" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_proteccion_consumidor" value="1" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_proteccion_consumidor" value="2" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_proteccion_consumidor" value="3" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_proteccion_consumidor" value="4" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_politico_proteccion_consumidor">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">5. La normativa autonómica tiene un impacto considerable en el funcionamiento del sector donde actuamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="politico_normativa_autonomica" value="0" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_normativa_autonomica" value="1" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_normativa_autonomica" value="2" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_normativa_autonomica" value="3" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_normativa_autonomica" value="4" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_politico_normativa_autonomica">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">6. La legislación medioambiental afecta al desarrollo de nuestro sector.</td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_medioambiental" value="0" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_medioambiental" value="1" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_medioambiental" value="2" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_medioambiental" value="3" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="politico_legislacion_medioambiental" value="4" class="mx-auto politico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_politico_legislacion_medioambiental">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Factores Políticos</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_politico">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">7. Las variaciones en el nivel de riqueza de la población impactan considerablemente en la demanda de los productos/servicios del sector donde operamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="economico_nivel_riqueza" value="0" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_nivel_riqueza" value="1" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_nivel_riqueza" value="2" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_nivel_riqueza" value="3" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_nivel_riqueza" value="4" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_economico_nivel_riqueza">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">8. Las expectativas de crecimiento económico generales afectan crucialmente al mercado donde operamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="economico_crecimiento" value="0" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_crecimiento" value="1" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_crecimiento" value="2" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_crecimiento" value="3" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_crecimiento" value="4" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_economico_crecimiento">0</span></td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2">9. La política de tipos de interés es fundamental en el desarrollo financiero del sector donde trabaja nuestra empresa.</td>
                        <td class="border border-gray-300"><input type="radio" name="economico_tipos_interes" value="0" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_tipos_interes" value="1" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_tipos_interes" value="2" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_tipos_interes" value="3" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_tipos_interes" value="4" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_economico_tipos_interes">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">10. La globalización permite a nuestra industria gozar de importantes oportunidades en nuevos mercados.</td>
                        <td class="border border-gray-300"><input type="radio" name="economico_globalizacion" value="0" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_globalizacion" value="1" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_globalizacion" value="2" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_globalizacion" value="3" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_globalizacion" value="4" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_economico_globalizacion">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">11. La situación del empleo es fundamental para el desarrollo económico de nuestra empresa y nuestro sector.</td>
                        <td class="border border-gray-300"><input type="radio" name="economico_empleo" value="0" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_empleo" value="1" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_empleo" value="2" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_empleo" value="3" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_empleo" value="4" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_economico_empleo">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">12. Las expectativas del ciclo económico de nuestro sector impactan en la situación económica de sus empresas.</td>
                        <td class="border border-gray-300"><input type="radio" name="economico_ciclo_economico" value="0" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_ciclo_economico" value="1" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_ciclo_economico" value="2" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_ciclo_economico" value="3" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="economico_ciclo_economico" value="4" class="mx-auto economico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_economico_ciclo_economico">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Factores Económicos</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_economico">0</span></td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2">13. Los cambios en la composición étnica de los consumidores de nuestro mercado está teniendo un notable impacto.</td>
                        <td class="border border-gray-300"><input type="radio" name="social_composicion_etnica" value="0" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_composicion_etnica" value="1" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_composicion_etnica" value="2" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_composicion_etnica" value="3" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_composicion_etnica" value="4" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_social_composicion_etnica">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">14. El envejecimiento de la población tiene un importante impacto en la demanda.</td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento" value="0" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento" value="1" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento" value="2" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento" value="3" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento" value="4" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_social_envejecimiento">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">15. Los nuevos estilos de vida y tendencias originan cambios en la oferta de nuestro sector.</td>
                        <td class="border border-gray-300"><input type="radio" name="social_estilos_vida" value="0" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_estilos_vida" value="1" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_estilos_vida" value="2" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_estilos_vida" value="3" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_estilos_vida" value="4" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_social_estilos_vida">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">16. El envejecimiento de la población tiene un importante impacto en la oferta del sector donde operamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento_oferta" value="0" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento_oferta" value="1" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento_oferta" value="2" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento_oferta" value="3" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_envejecimiento_oferta" value="4" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_social_envejecimiento_oferta">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">17. Los clientes de nuestro mercado exigen que seamos socialmente responsables, en el plano medioambiental.</td>
                        <td class="border border-gray-300"><input type="radio" name="social_responsabilidad" value="0" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_responsabilidad" value="1" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_responsabilidad" value="2" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_responsabilidad" value="3" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_responsabilidad" value="4" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_social_responsabilidad">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">18. La creciente preocupación social por el medio ambiente impacta notablemente en la demanda de productos/servicios ofertados en nuestro mercado.</td>
                        <td class="border border-gray-300"><input type="radio" name="social_medio_ambiente" value="0" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_medio_ambiente" value="1" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_medio_ambiente" value="2" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_medio_ambiente" value="3" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="social_medio_ambiente" value="4" class="mx-auto social" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_social_medio_ambiente">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Factores Sociales</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_social">0</span></td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2">19. Internet, el comercio electrónico, el wireless y otras NTIC están impactando en la demanda de nuestros productos/servicios y en los de la competencia.</td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_internet" value="0" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_internet" value="1" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_internet" value="2" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_internet" value="3" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_internet" value="4" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_tecnologico_internet">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">20. El empleo de NTICs es generalizado en el sector donde trabajamos.</td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_ntics" value="0" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_ntics" value="1" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_ntics" value="2" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_ntics" value="3" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_ntics" value="4" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_tecnologico_ntics">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">21. En nuestro sector, es de gran importancia ser pionero o referente en el empleo de aplicaciones tecnológicas.</td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_pionero" value="0" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_pionero" value="1" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_pionero" value="2" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_pionero" value="3" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_pionero" value="4" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_tecnologico_pionero">0</span></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">22. En el sector donde operamos, para ser competitivos, es condición "sine qua non" innovar constantemente.</td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_innovacion" value="0" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_innovacion" value="1" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_innovacion" value="2" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_innovacion" value="3" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_innovacion" value="4" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_tecnologico_innovacion">0</span></td>
                    </tr>
                    <tr>

                    <tr>

                        <td class="border border-gray-300 px-4 py-2">23. En nuestro sector, las políticas medioambientales son una fuente de ventajas competitivas.</td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_politicas_medioambientales" value="0" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_politicas_medioambientales" value="1" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_politicas_medioambientales" value="2" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_politicas_medioambientales" value="3" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_politicas_medioambientales" value="4" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_tecnologico_politicas_medioambientales">0</span></td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2">24. La creciente preocupación social por el medio ambiente impacta notablemente en la demanda de productos/servicios ofertados en nuestro mercado.</td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_preocupacion_medioambiental" value="0" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_preocupacion_medioambiental" value="1" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_preocupacion_medioambiental" value="2" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_preocupacion_medioambiental" value="3" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_preocupacion_medioambiental" value="4" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_tecnologico_preocupacion_medioambiental">0</span></td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2">25. El factor ecológico es una fuente de diferenciación clara en el sector donde opera nuestra empresa.</td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_factor_ecologico" value="0" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_factor_ecologico" value="1" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_factor_ecologico" value="2" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_factor_ecologico" value="3" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300"><input type="radio" name="tecnologico_factor_ecologico" value="4" class="mx-auto tecnologico" onclick="calcularPuntaje()"></td>
                        <td class="border border-gray-300 text-center"><span id="puntaje_tecnologico_factor_ecologico">0</span></td>
                    </tr>

                    <tr>
                    <td class="border border-gray-300 px-4 py-2 font-semibold">Subtotal Factores Tecnológicos</td>
                    <td colspan="5" class="border border-gray-300"></td>
                    <td class="border border-gray-300 text-center font-semibold"><span id="subtotal_tecnologico">0</span></td>
                </tr>

                    <tr class="bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 font-semibold text-lg">TOTAL GENERAL</td>
                        <td colspan="5" class="border border-gray-300"></td>
                        <td class="border border-gray-300 text-center font-semibold text-lg"><span id="total_general">0</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Secciones adicionales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="oportunidades" class="block text-lg font-semibold mb-2">Oportunidades</label>
                <div id="oportunidades-container">
                    <div class="flex gap-3 mb-2">
                        <input type="text" name="oportunidades[]" class="w-full p-3 border border-gray-300 rounded" placeholder="Oportunidad 1" />
                        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                    </div>
                </div>
                <button type="button" onclick="addItem('oportunidades')" class="bg-green-500 text-white px-4 py-2 mt-3 rounded">Añadir Oportunidad</button>
            </div>

            <div>
                <label for="amenazas" class="block text-lg font-semibold mb-2">Amenazas</label>
                <div id="amenazas-container">
                    <div class="flex gap-3 mb-2">
                        <input type="text" name="amenazas[]" class="w-full p-3 border border-gray-300 rounded" placeholder="Amenaza 1" />
                        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
                    </div>
                </div>
                <button type="button" onclick="addItem('amenazas')" class="bg-green-500 text-white px-4 py-2 mt-3 rounded">Añadir Amenaza</button>
            </div>
        </div>

        <div class="mb-6">
            <label for="conclusion" class="block text-lg font-semibold mb-2">Conclusión</label>
            <textarea class="w-full p-3 border border-gray-300 rounded" id="conclusion" name="conclusion" rows="4"></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">
            Guardar análisis
        </button>
    </form>
</div>

<script>
function calcularPuntaje() {
    // Actualizar puntajes individuales
    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
        const name = input.name;
        const value = input.value;
        document.getElementById(puntaje_${name}).textContent = value;
    });

    // Calcular subtotales por categoría PEST
    const calcularSubtotal = (clase) => {
        let subtotal = 0;
        document.querySelectorAll(input.${clase}:checked).forEach(input => {
            subtotal += parseInt(input.value);
        });
        return subtotal;
    };

    // Calcular subtotales
    const subtotalPolitico = calcularSubtotal('politico');
    const subtotalEconomico = calcularSubtotal('economico');
    const subtotalSocial = calcularSubtotal('social');
    const subtotalTecnologico = calcularSubtotal('tecnologico');
    
    // Actualizar subtotales en la tabla
    document.getElementById('subtotal_politico').textContent = subtotalPolitico;
    document.getElementById('subtotal_economico').textContent = subtotalEconomico;
    document.getElementById('subtotal_social').textContent = subtotalSocial;
    document.getElementById('subtotal_tecnologico').textContent = subtotalTecnologico;

    // Calcular total general (suma de todos los puntos)
    const totalGeneral = subtotalPolitico + subtotalEconomico + subtotalSocial + subtotalTecnologico;
    document.getElementById('total_general').textContent = totalGeneral;

    // Generar conclusión automática basada en los subtotales
    generarConclusion(subtotalPolitico, subtotalEconomico, subtotalSocial, subtotalTecnologico);
}

function generarConclusion(politico, economico, social, tecnologico) {
    // Umbral para "impacto notable" (70% de 24 puntos = 16.8 ≈ 17)
    const umbral = 17;
    
    // 1. Conclusión para Factores Sociales y Demográficos
    const conclusionSocial = social >= umbral 
        ? "HAY UN NOTABLE IMPACTO DE FACTORES SOCIALES Y DEMOGRÁFICOS EN EL FUNCIONAMIENTO DE LA EMPRESA" 
        : "NO HAY UN NOTABLE IMPACTO DE FACTORES SOCIALES Y DEMOGRÁFICOS EN EL FUNCIONAMIENTO DE LA EMPRESA";
    
    // 2. Conclusión para Factores Políticos
    const conclusionPolitico = politico >= umbral 
        ? "HAY UN NOTABLE IMPACTO DE FACTORES POLÍTICOS EN EL FUNCIONAMIENTO DE LA EMPRESA" 
        : "NO HAY UN NOTABLE IMPACTO DE FACTORES POLÍTICOS EN EL FUNCIONAMIENTO DE LA EMPRESA";
    
    // 3. Conclusión para Factores Económicos
    const conclusionEconomico = economico >= umbral 
        ? "HAY UN NOTABLE IMPACTO DE FACTORES ECONÓMICOS EN EL FUNCIONAMIENTO DE LA EMPRESA" 
        : "NO HAY UN NOTABLE IMPACTO DE FACTORES ECONÓMICOS EN EL FUNCIONAMIENTO DE LA EMPRESA";
    
    // 4. Conclusión para Factores Tecnológicos
    const conclusionTecnologico = tecnologico >= umbral 
        ? "HAY UN NOTABLE IMPACTO DE FACTORES TECNOLÓGICOS EN EL FUNCIONAMIENTO DE LA EMPRESA" 
        : "NO HAY UN NOTABLE IMPACTO DE FACTORES TECNOLÓGICOS EN EL FUNCIONAMIENTO DE LA EMPRESA";
    
    // 5. Conclusión para Factor Medioambiental (suma de preguntas específicas)
    const preguntasMedioAmbiente = [
        "politico_legislacion_medioambiental",
        "social_responsabilidad",
        "social_medio_ambiente",
        "tecnologico_politicas_medioambientales",
        "tecnologico_preocupacion_medioambiental",
        "tecnologico_factor_ecologico"
    ];
    
    let medioAmbienteTotal = 0;
    preguntasMedioAmbiente.forEach(pregunta => {
        const valor = document.querySelector(input[name="${pregunta}"]:checked)?.value || 0;
        medioAmbienteTotal += parseInt(valor);
    });
    
    const conclusionMedioAmbiente = medioAmbienteTotal >= umbral 
        ? "HAY UN NOTABLE IMPACTO DEL FACTOR MEDIO AMBIENTAL EN EL FUNCIONAMIENTO DE LA EMPRESA" 
        : "NO HAY UN NOTABLE IMPACTO DEL FACTOR MEDIO AMBIENTAL EN EL FUNCIONAMIENTO DE LA EMPRESA";
    
    // Unir todas las conclusiones con saltos de línea
    const conclusionFinal = `
    1. ${conclusionSocial}
    2. ${conclusionPolitico}
    3. ${conclusionEconomico}
    4. ${conclusionTecnologico}
    5. ${conclusionMedioAmbiente}
    `;
    
    document.getElementById('conclusion').value = conclusionFinal.trim();
}

function addItem(type) {
    const container = document.getElementById(${type}-container);
    const index = container.children.length + 1;
    const newItem = document.createElement('div');
    newItem.classList.add('flex', 'gap-3', 'mb-2');
    newItem.innerHTML = `
        <input type="text" name="${type}[]" class="w-full p-3 border border-gray-300 rounded" placeholder="${type.slice(0, -1)} ${index}" />
        <button type="button" onclick="removeItem(this)" class="bg-red-500 text-white px-2 rounded">Eliminar</button>
    `;
    container.appendChild(newItem);
}

function removeItem(button) {
    button.parentElement.remove();
}
</script>
@endsection