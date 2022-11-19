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
                                                    v-model="fi.proveedores"
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
                                                    v-model="fi.fuentes_moviles"
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
                                                        fi.actividad_agricola
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
                                                    v-model="fi.huella_base"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    @input="
                                                        if (
                                                            fi.huella_base === 0
                                                        )
                                                            fi.metas_mitigacion = 0;
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
                                                        fi.valor_huella_base
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
                                                        fi.huella_comparativo
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    @input="
                                                        fi.verificacion_interna =
                                                            null;
                                                        if (
                                                            fi.huella_comparativo ===
                                                            0
                                                        )
                                                            fi.verificacion_interna = 0;
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
                                                        fi.valor_huella_comparativo
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
                                                    v-model="fi.alcances_huella"
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
                                                    v-model="fi.priorizacion"
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
                                                    v-model="fi.indicador"
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
                                                        fi.verificacion_interna
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    :disabled="
                                                        fi.huella_comparativo ===
                                                        0
                                                    "
                                                    @input="
                                                        if (
                                                            fi.verificacion_interna ===
                                                            0
                                                        )
                                                            fi.metas_mitigacion = 0;
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
                                                        fi.optimizacion_procesos
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
                                                        fi.verificacion_tercero
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
                                                        fi.declaracion_conformidad_tercero
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
                                                    v-model="fi.acciones_mejora"
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
                                                        fi.metas_mitigacion
                                                    "
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    :disabled="
                                                        fi.huella_base == 0 ||
                                                        fi.verificacion_interna ==
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
                                                    v-model="fi.meta_reduccion"
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
                                                    v-model="fi.anio_meta"
                                                    :options="options_si_no"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    @input="
                                                        fi.efecto_invernadero =
                                                            null;
                                                        if (fi.anio_meta === 0)
                                                            fi.efecto_invernadero = 2;
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
                                                        fi.anio_proyeccion_meta
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
                                                    v-model="fi.meta_alineada"
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
                                                    v-model="fi.metodologias"
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
                                                        fi.seguimiento_cumplimiento
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
                                                        fi.efecto_invernadero
                                                    "
                                                    :options="options_puntaje_1"
                                                    placeholder="Seleccione una opción"
                                                    required
                                                    :disabled="
                                                        fi.anio_meta === 0
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
                                                    v-model="fi.sumideros"
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
                                                        fi.informacion_mensual
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
                                                        fi.diagrama_procesos
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
                                                    v-model="fi.areas_sumideros"
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
                                                        fi.informacion_centralizada
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
                                                        fi.soportes_consumos
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
                                                        fi.informacion_anio
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
                                                        fi.estimaciones_consumos
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
                                                        fi.consumos_energeticos
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
                                                        fi.sustento_metodologico
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
                                                        fi.compartira_reporte
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
                                                    v-model="fi.toma_decisiones"
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

export default {
    data() {
        return {
            fi: {
                verificacion_interna: "",
            }, //form información

            paso: 2,
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

        submit(e) {
            switch (this.paso) {
                case 1:
                    if (
                        this.fi.proveedores !== "" ||
                        this.fi.fuentes_moviles !== "" ||
                        this.fi.actividad_agricola !== ""
                    ) {
                        this.paso = 2;
                    }
                    break;
                case 2:
                    if (
                        this.fi.huella_base !== "" ||
                        this.fi.valor_huella_base !== "" ||
                        this.fi.huella_comparativo !== "" ||
                        this.fi.valor_huella_comparativo !== "" ||
                        this.fi.alcances_huella !== "" ||
                        this.fi.priorizacion !== "" ||
                        this.fi.indicador !== ""
                    ) {
                        this.paso = 3;
                    }
                    break;
                case 3:
                    if (
                        this.fi.verificacion_interna !== "" ||
                        this.fi.optimizacion_procesos !== "" ||
                        this.fi.verificacion_tercero !== "" ||
                        this.fi.declaracion_conformidad_tercero !== "" ||
                        this.fi.acciones_mejora !== ""
                    ) {
                        this.paso = 4;
                    }
                    break;
                case 4:
                    if (
                        this.fi.metas_mitigacion !== "" ||
                        this.fi.meta_reduccion !== "" ||
                        this.fi.anio_meta !== "" ||
                        this.fi.anio_proyeccion_meta !== "" ||
                        this.fi.meta_alineada !== "" ||
                        this.fi.metodologias !== "" ||
                        this.fi.seguimiento_cumplimiento !== ""
                    ) {
                        this.paso = 5;
                    }
                    break;
                case 5:
                    if (
                        this.fi.efecto_invernadero !== "" ||
                        this.fi.sumideros !== "" ||
                        this.fi.informacion_mensual !== "" ||
                        this.fi.diagrama_procesos !== "" ||
                        this.fi.areas_sumideros !== "" ||
                        this.fi.informacion_centralizada !== "" ||
                        this.fi.soportes_consumos !== "" ||
                        this.fi.informacion_anio !== "" ||
                        this.fi.estimaciones_consumos !== "" ||
                        this.fi.consumos_energeticos !== "" ||
                        this.fi.sustento_metodologico !== "" ||
                        this.fi.compartira_reporte !== "" ||
                        this.fi.toma_decisiones !== ""
                    ) {
                        //guardar
                    }
                    break;
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
