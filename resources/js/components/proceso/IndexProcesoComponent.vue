<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Procesos</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="formulario-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#formulario"
                            type="button"
                            role="tab"
                            aria-controls="formulario"
                            aria-selected="true"
                        >
                            Formulario
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="construccion-proceso-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#construccion-proceso"
                            type="button"
                            role="tab"
                            aria-controls="construccion-proceso"
                            aria-selected="false"
                        >
                            Construcción del proceso productivo de la empresa
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="construccion-anio-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#construccion-anio"
                            type="button"
                            role="tab"
                            aria-controls="construccion-anio"
                            aria-selected="false"
                            @click="tablaEmisiones()"
                        >
                            Construcción de año base de emisiones de GEI
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div
                        class="tab-pane fade show active"
                        id="formulario"
                        role="tabpanel"
                        aria-labelledby="formulario-tab"
                    >
                        <ul
                            class="nav flex-column mb-3"
                            id="pills-tab"
                            role="tablist"
                        >
                            <li class="nav-item" role="presentation">
                                <span
                                    class="badge rounded-pill"
                                    :class="
                                        paso == 1
                                            ? 'active bg-primary'
                                            : 'bg-secondary'
                                    "
                                    id="pills-informacion-basica-tab"
                                    >1</span
                                >
                                Información básica
                            </li>
                            <li class="nav-item" role="presentation">
                                <span
                                    class="badge bg-primary rounded-pill"
                                    :class="
                                        paso == 2
                                            ? 'active bg-primary'
                                            : 'bg-secondary'
                                    "
                                    id="pills-datos-generales-tab"
                                    >2
                                </span>
                                Cálculo y reporte de la Huella de Carbono
                                Organizacional
                            </li>
                            <li class="nav-item" role="presentation">
                                <span
                                    class="badge bg-primary rounded-pill"
                                    :class="
                                        paso == 3
                                            ? 'active bg-primary'
                                            : 'bg-secondary'
                                    "
                                    id="pills-datos-empresa-tab"
                                    >3
                                </span>
                                Verificación de la Huella de Carbono
                                Organizacional
                            </li>
                            <li class="nav-item" role="presentation">
                                <span
                                    class="badge bg-primary rounded-pill"
                                    :class="
                                        paso == 4
                                            ? 'active bg-primary'
                                            : 'bg-secondary'
                                    "
                                    id="pills-datos-empresa-tab"
                                    >4
                                </span>
                                Planteamiento de Metas de Reducción de Huella de
                                Carbono Organizacional
                            </li>
                            <li class="nav-item" role="presentation">
                                <span
                                    class="badge bg-primary rounded-pill"
                                    :class="
                                        paso == 5
                                            ? 'active bg-primary'
                                            : 'bg-secondary'
                                    "
                                    id="pills-datos-empresa-tab"
                                    >5
                                </span>
                                Diligenciamiento cumplimiento de principios.
                            </li>
                        </ul>
                        <form @submit.prevent="submit">
                            <div class="tab-content" id="pills-tabContent">
                                <div
                                    v-if="paso == 1"
                                    class="tab-pane fade"
                                    :class="paso == 1 ? 'show active' : ''"
                                    id="pills-informacion-basica"
                                    role="tabpanel"
                                >
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La información que
                                                    reportará para el cálculo de
                                                    la huella de carbono incluye
                                                    datos de sus proveedores?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.datos_proveedores
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La empresa cuenta con
                                                    fuentes móviles propiedad de
                                                    la compañía o que la
                                                    organización asume el
                                                    combustible?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.fuentes_moviles"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La empresa realiza algún
                                                    tipo de actividad agrícola?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.actividad_agricola
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="col-lg-12 text-end">
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                >
                                                    Siguiente
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="paso == 2"
                                    class="tab-pane fade"
                                    :class="paso == 2 ? 'show active' : ''"
                                    id="pills-calculo"
                                    role="tabpanel"
                                >
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La empresa ha calculado su
                                                    huella de carbono
                                                    organizacional para un año
                                                    base?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.huella_base"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    @input="
                                                        if (
                                                            ie.huella_base === 0
                                                        )
                                                            ie.metas_mitigacion = 0;
                                                    "
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Cuál es el valor de la
                                                    huella de carbono de la
                                                    empresa en su año base?
                                                </label>
                                                <input
                                                    v-model="
                                                        ie.valor_huella_base
                                                    "
                                                    class="form-control"
                                                    type="number"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La empresa ha calculado su
                                                    huella de carbono
                                                    organizacional para un año
                                                    comparativo?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.huella_comparativo
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    @input="
                                                        ie.verificacion_interna =
                                                            null;
                                                        if (
                                                            ie.huella_comparativo ===
                                                            0
                                                        )
                                                            ie.verificacion_interna = 0;
                                                    "
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Cuál es el valor de la
                                                    huella de carbono de la
                                                    empresa en su año
                                                    comparativo?
                                                </label>
                                                <input
                                                    v-model="
                                                        ie.valor_huella_comparativo
                                                    "
                                                    class="form-control"
                                                    type="number"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Qué alcances - categorías
                                                    cubre el cálculo de la
                                                    huella de carbono
                                                    organizacional?
                                                </label>
                                                <textarea
                                                    v-model="ie.alcances_huella"
                                                    class="form-control"
                                                    required
                                                ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Se realizó una
                                                    priorización de fuentes de
                                                    emisión para definir el
                                                    Otras Emisiones Indirectas?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.priorizacion"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La empresa ha definido
                                                    algún indicador de
                                                    intensidad o correlación de
                                                    sus emisiones con su
                                                    producción o servicios
                                                    prestados?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.indicador"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-6 text-start"
                                                >
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        @click="paso = 1"
                                                    >
                                                        Atrás
                                                    </button>
                                                </div>
                                                <div class="col-lg-6 text-end">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary"
                                                    >
                                                        Siguiente
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="paso == 3"
                                    class="tab-pane fade"
                                    :class="paso == 3 ? 'show active' : ''"
                                    id="pills-verificacion"
                                    role="tabpanel"
                                >
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La empresa ha realizado un
                                                    proceso de revisión y
                                                    verificación interna de su
                                                    huella de carbono
                                                    organizacional del año base,
                                                    por parte de alguien
                                                    diferente a quien la calculó
                                                    y reportó?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.verificacion_interna
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    :disabled="
                                                        ie.huella_comparativo ===
                                                        0
                                                    "
                                                    @input="
                                                        if (
                                                            ie.verificacion_interna ==
                                                            0
                                                        )
                                                            ie.metas_mitigacion = 0;
                                                    "
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Se optimizaron los
                                                    procesos de cálculo y
                                                    reporte como producto de
                                                    esta preverificación?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.optimizacion_procesos
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Un tercero ha realizado el
                                                    proceso de verificación de
                                                    la huella de carbono
                                                    organizacional del año base?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.verificacion_tercero
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Se obtuvo la declaración
                                                    de conformidad asociada en
                                                    el proceso de verificación
                                                    por parte del tercero?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.declaracion_conformidad_tercero
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Se identificaron las
                                                    acciones de mejora para
                                                    poder cumplir con todos los
                                                    requisitos del proceso?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.acciones_mejora"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-6 text-start"
                                                >
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        @click="paso = 2"
                                                    >
                                                        Atrás
                                                    </button>
                                                </div>
                                                <div class="col-lg-6 text-end">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary"
                                                    >
                                                        Siguiente
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="paso == 4"
                                    class="tab-pane fade"
                                    :class="paso == 4 ? 'show active' : ''"
                                    id="pills-planteamiento"
                                    role="tabpanel"
                                >
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿En la empresa se ha
                                                    planteado metas de
                                                    mitigación de Gases Efecto
                                                    Invernadero (GEI)?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.metas_mitigacion
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    :disabled="
                                                        ie.huella_base === 0 ||
                                                        ie.verificacion_interna ==
                                                            0
                                                    "
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Cuál es la meta de
                                                    reducción de emisiones de
                                                    GEI de la empresa? (t CO2eq
                                                    / año)
                                                </label>
                                                <input
                                                    v-model="ie.meta_reduccion"
                                                    class="form-control"
                                                    type="number"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Conoce el año de
                                                    proyección para esa meta?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.anio_meta"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    @input="
                                                        ie.efecto_invernadero =
                                                            null;
                                                        if (ie.anio_meta === 0)
                                                            ie.efecto_invernadero = 2;
                                                    "
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿A que año está proyectada
                                                    esta meta?
                                                </label>
                                                <input
                                                    v-model="
                                                        ie.anio_proyeccion_meta
                                                    "
                                                    class="form-control"
                                                    type="number"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La meta está alineada con
                                                    los compromisos nacionales
                                                    (NDC), con las metas de
                                                    reducción del acuerdo de
                                                    París y/o con otro
                                                    compromiso sectorial o de
                                                    otro tipo?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.meta_alineada"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Cuál de éstas metodologías
                                                    empleó la empresa en la
                                                    formulación de la meta?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.metodologias"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Se ha realizado algún
                                                    seguimiento al cumplimiento
                                                    de la meta o se cuenta con
                                                    un plan de monitoreo
                                                    asociado?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.seguimiento_cumplimiento
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-6 text-start"
                                                >
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        @click="paso = 3"
                                                    >
                                                        Atrás
                                                    </button>
                                                </div>
                                                <div class="col-lg-6 text-end">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary"
                                                    >
                                                        Siguiente
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="paso == 5"
                                    class="tab-pane fade"
                                    :class="paso == 5 ? 'show active' : ''"
                                    id="pills-diligenciamiento"
                                    role="tabpanel"
                                >
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <p><b>Pertinencia</b></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La organización para el
                                                    desarrollo de sus
                                                    actividades productivas y/o
                                                    administrativas ha
                                                    identificado las fuentes de
                                                    gases de efecto invernadero?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.efecto_invernadero
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    :disabled="
                                                        ie.anio_meta === 0
                                                    "
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La organización tiene
                                                    sumideros y/o reservorios en
                                                    los límites de sus
                                                    instalaciones?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.sumideros"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <p><b>Integralidad</b></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿En la organización cuentan
                                                    con información mensual de
                                                    consumos de todas las
                                                    fuentes GEI?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.informacion_mensual
                                                    "
                                                    :options="options_puntaje_2"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La organización cuenta con
                                                    un diagrama de procesos en
                                                    donde se identifica el
                                                    energético necesario para
                                                    desarrollar cada etapa?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.diagrama_procesos
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Se cuenta con las
                                                    características de las áreas
                                                    de sumidero (edad, especie,
                                                    hectáreas)?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.areas_sumideros"
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <p><b>Coherencia</b></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La información de consumos
                                                    de las fuentes GEI se
                                                    encuentra centralizada?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.informacion_centralizada
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La información de consumos
                                                    de las fuentes GEI cuenta
                                                    con soportes como facturas,
                                                    plataforma, registros?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.soportes_consumos
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La organización cuenta con
                                                    más de un año de información
                                                    de consumos de las fuentes
                                                    GEI?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.informacion_anio
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <p><b>Exactitud</b></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿La organización ha
                                                    realizado estimaciones de
                                                    consumos energéticos de las
                                                    fuentes GEI?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.estimaciones_consumos
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿Los consumos energéticos
                                                    están directamente
                                                    relacionados con la
                                                    producción?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.consumos_energeticos
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿En caso de tener
                                                    estimaciones de consumos
                                                    energéticos, se cuenta con
                                                    sustento metodológico para
                                                    los cálculos?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.sustento_metodologico
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <p><b>Transparencia</b></p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿El reporte de huella de
                                                    carbono lo compartirá con
                                                    las partes interesadas?
                                                </label>
                                                <Multiselect
                                                    v-model="
                                                        ie.compartira_reporte
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="mb-3">
                                                <label class="required"
                                                    >¿El reporte de huella de
                                                    carbono es previsto para la
                                                    toma de decisiones?
                                                </label>
                                                <Multiselect
                                                    v-model="ie.toma_decisiones"
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                />
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-6 text-start"
                                                >
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        @click="paso = 4"
                                                    >
                                                        Atrás
                                                    </button>
                                                </div>
                                                <div class="col-lg-6 text-end">
                                                    <button
                                                        type="button"
                                                        class="btn btn-primary"
                                                        @click="submit()"
                                                    >
                                                        Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="construccion-proceso"
                        role="tabpanel"
                        aria-labelledby="construccion-proceso-tab"
                    >
                        <div class="mb-3">
                            <div class="accordion" id="acordeon-procesos">
                                <div
                                    class="accordion-item"
                                    v-for="(v, i) in $v.procesos.$each.$iter"
                                    v-bind:key="i"
                                >
                                    <h2
                                        class="accordion-header"
                                        :id="'panelsStayOpen-heading-' + i"
                                    >
                                        <button
                                            class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            :data-bs-target="
                                                '#panelsStayOpen-collapse-' + i
                                            "
                                            aria-expanded="true"
                                            :aria-controls="
                                                'panelsStayOpen-collapse-' + i
                                            "
                                        >
                                            {{ v.nombre.$model }}
                                        </button>
                                    </h2>

                                    <div
                                        :id="'panelsStayOpen-collapse-' + i"
                                        class="accordion-collapse collapse show"
                                        :aria-labelledby="
                                            'panelsStayOpen-heading-' + i
                                        "
                                    >
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Nombre del proceso</label
                                                >
                                                <input
                                                    v-model.trim="
                                                        v.nombre.$model
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            v.nombre.$error,
                                                        'is-valid':
                                                            !v.nombre.$invalid,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="
                                                            !v.nombre.required
                                                        "
                                                        >{{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Descripción del
                                                    proceso</label
                                                >
                                                <textarea
                                                    v-model.trim="
                                                        v.descripcion.$model
                                                    "
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            v.descripcion
                                                                .$error,
                                                        'is-valid':
                                                            !v.descripcion
                                                                .$invalid,
                                                    }"
                                                >
                                                </textarea>
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="
                                                            !v.descripcion
                                                                .required
                                                        "
                                                        >{{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Equipo de consumo (fuente
                                                    GEI)</label
                                                >
                                                <Multiselect
                                                    v-model.trim="
                                                        v.equipos.$model
                                                    "
                                                    mode="tags"
                                                    :groups="true"
                                                    :searchable="true"
                                                    :options="
                                                        options_equipo_consumo
                                                    "
                                                    placeholder="Selección múltiple"
                                                    :class="{
                                                        'is-invalid':
                                                            v.equipos.$error,
                                                        'is-valid':
                                                            !v.equipos.$invalid,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="
                                                            v.equipos.required
                                                        "
                                                    >
                                                        {{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Energéticos
                                                    utilizados</label
                                                >
                                                <Multiselect
                                                    v-model.trim="
                                                        v.energetico.$model
                                                    "
                                                    :options="
                                                        options_energeticos
                                                    "
                                                    valueProp="id"
                                                    label="nombre"
                                                    mode="tags"
                                                    :searchable="true"
                                                    placeholder="Selección múltiple"
                                                    :class="{
                                                        'is-invalid':
                                                            v.energetico.$error,
                                                        'is-valid':
                                                            !v.energetico
                                                                .$invalid,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="
                                                            v.energetico
                                                                .required
                                                        "
                                                    >
                                                        {{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            <button
                                class="btn btn-success"
                                @click="agregarElementoProceso()"
                            >
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="construccion-anio"
                        role="tabpanel"
                        aria-labelledby="construccion-anio-tab"
                    >
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Energético</th>
                                        <th
                                            v-for="(c, i) in cabecera_tabla"
                                            v-bind:key="i"
                                        >
                                            {{ c }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(e, i) in energeticos"
                                        v-bind:key="i"
                                    >
                                        <td>Energético {{ i + 1 }}</td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import Parametro from "../../models/Parametro";
import InformacionEmpresa from "../../models/InformacionEmpresa";

export default {
    data() {
        return {
            ie: new InformacionEmpresa({
                datos_proveedores: null,
                fuentes_moviles: null,
                actividad_agricola: null,
                huella_base: null,
                valor_huella_base: null,
                huella_comparativo: null,
                valor_huella_comparativo: null,
                alcances_huella: null,
                priorizacion: null,
                indicador: null,
                verificacion_interna: null,
                optimizacion_procesos: null,
                verificacion_tercero: null,
                declaracion_conformidad_tercero: null,
                acciones_mejora: null,
                metas_mitigacion: null,
                meta_reduccion: null,
                anio_meta: null,
                anio_proyeccion_meta: null,
                meta_alineada: null,
                metodologias: null,
                seguimiento_cumplimiento: null,
                efecto_invernadero: null,
                sumideros: null,
                informacion_mensual: null,
                diagrama_procesos: null,
                areas_sumideros: null,
                informacion_centralizada: null,
                soportes_consumos: null,
                informacion_anio: null,
                estimaciones_consumos: null,
                consumos_energeticos: null,
                sustento_metodologico: null,
                compartira_reporte: null,
                toma_decisiones: null,
                usuario_creacion_id: null,
                empresa_id: null,
                sede_id: null,
            }),

            paso: 1,
            procesos: [
                {
                    nombre: "Proceso 1",
                    descripcion: "",
                    equipos: [],
                    energetico: [],
                },
            ],
            options_anio: [],
            options_mes: [],

            anio: "",
            mes: "",
            fecha_base: "",

            cabecera_tabla: [],

            array_meses: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],

            array_fuentes_moviles: [],

            options_sector: [],

            options_si_no: [
                { value: 0, label: "No" },
                { value: 1, label: "Si" },
            ],
            options_puntaje_1: [
                { value: 0, label: "No" },
                { value: 2, label: "Si" },
            ],
            options_puntaje_2: [
                { value: 0, label: "No" },
                { value: 1, label: "Parcialmente" },
                { value: 2, label: "Si" },
            ],

            options_equipo_consumo: [],
            options_energeticos: [],
            energeticos: [{ nombre: "" }, { nombre: "" }, { nombre: "" }],
            required: "Este campo es requerido",
            options: [{ value: 1, label: "1" }],
        };
    },
    validations: {
        fi: {
            required,
        },
        procesos: {
            required,

            $each: {
                nombre: {
                    required,
                },
                descripcion: {
                    required,
                },
                equipos: {
                    required,
                },
                energetico: {
                    required,
                },
            },
        },
    },
    mounted() {
        this.getParametros(3, "options_sector");
        this.getParametros(7, "options_anio");
        this.getParametros(8, "options_mes");
        this.getParametros(11, "options_energeticos");
        this.getEquiposConsumo();
    },
    methods: {
        async getParametros(tipo_parametro_id, variable) {
            //1 departamentos
            //3 sectores
            //4 CIIUs
            //5 tamaños de empresa
            //6 número de empleados
            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },
        async getEquiposConsumo() {
            await axios
                .post("api/getEquiposConsumo")
                .then((response) => {
                    this.options_equipo_consumo = response.data;
                })
                .catch((error) => {
                    this.$root.mostrarMensaje(
                        "error",
                        "No se pudo verificar el convenio",
                        "error"
                    );
                });
        },
        agregarElementoProceso() {
            this.procesos.push({
                nombre: "",
                descripcion: "",
                equipos: [],
                energetico: [],
            });
        },

        async submit(e) {
            this.paso++;
            if (this.paso == 6) {
                this.$root.mostrarCargando("Guardando información");

                //reemplazar por datos de usuario y empresa
                this.ie.usuario_creacion_id = 1;
                this.ie.empresa_id = 1;
                this.ie.sede_id = 1;

                await this.ie.save();

                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Información guardada exitosamente",
                    "success"
                );
            }
        },
        tablaEmisiones() {
            this.cabecera_tabla = [];
            this.fecha_base = new Date(
                this.anio + "-" + this.mes + "-01 00:00"
            );

            for (var i = 0; i < 12; i++) {
                var future = new Date(
                    this.fecha_base.getFullYear(),
                    this.fecha_base.getMonth() + i,
                    1
                );
                var month = this.array_meses[future.getMonth()];
                var year = future.getFullYear();
                this.cabecera_tabla.push(
                    "Mes " + (i + 1) + " (" + month + " " + year + ")"
                );
            }
        },
    },
};
</script>
<style>
textarea.form-control {
    max-height: 80px;
    min-height: 80px;
}
</style>
