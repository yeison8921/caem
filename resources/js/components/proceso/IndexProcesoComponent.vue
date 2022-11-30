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
                            id="consumos-indirectos-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#consumos-indirectos"
                            type="button"
                            role="tab"
                            aria-controls="consumos-indirectos"
                            aria-selected="false"
                        >
                            Consumos indirectos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="inicio-consumos-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#inicio-consumos"
                            type="button"
                            role="tab"
                            aria-controls="inicio-consumos"
                            aria-selected="false"
                        >
                            Información inicio de consumos
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
                            @click="getFuentesEmision()"
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
                        <form @submit.prevent="guardarInformacion">
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
                                                        ie.valor_huella_base =
                                                            null;
                                                        ie.huella_comparativo =
                                                            null;
                                                        ie.valor_huella_comparativo =
                                                            null;
                                                        ie.alcances_huella =
                                                            null;
                                                        ie.priorizacion = null;
                                                        ie.indicador = null;
                                                    "
                                                />
                                            </div>
                                            <div v-if="ie.huella_base">
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
                                                        >¿La empresa ha
                                                        calculado su huella de
                                                        carbono organizacional
                                                        para un año comparativo?
                                                    </label>
                                                    <Multiselect
                                                        v-model="
                                                            ie.huella_comparativo
                                                        "
                                                        :options="options_si_no"
                                                        placeholder="Seleccione una opción"
                                                        required
                                                        @input="
                                                            ie.valor_huella_comparativo =
                                                                null;
                                                            ie.alcances_huella =
                                                                null;
                                                            ie.priorizacion =
                                                                null;
                                                            ie.indicador = null;
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div
                                                v-if="
                                                    ie.huella_base &&
                                                    ie.huella_comparativo
                                                "
                                            >
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
                                                        >¿Qué alcances -
                                                        categorías cubre el
                                                        cálculo de la huella de
                                                        carbono organizacional?
                                                    </label>
                                                    <textarea
                                                        v-model="
                                                            ie.alcances_huella
                                                        "
                                                        class="form-control"
                                                        required
                                                    ></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="required"
                                                        >¿Se realizó una
                                                        priorización de fuentes
                                                        de emisión para definir
                                                        el Otras Emisiones
                                                        Indirectas?
                                                    </label>
                                                    <Multiselect
                                                        v-model="
                                                            ie.priorizacion
                                                        "
                                                        :options="options_si_no"
                                                        placeholder="Seleccione una opción"
                                                        required
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="required"
                                                        >¿La empresa ha definido
                                                        algún indicador de
                                                        intensidad o correlación
                                                        de sus emisiones con su
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
                                                    @input="
                                                        ie.optimizacion_procesos =
                                                            null;
                                                        ie.verificacion_tercero =
                                                            null;
                                                        ie.declaracion_conformidad_tercero =
                                                            null;
                                                        ie.acciones_mejora =
                                                            null;
                                                    "
                                                />
                                            </div>
                                            <div v-if="ie.verificacion_interna">
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
                                                        >¿Un tercero ha
                                                        realizado el proceso de
                                                        verificación de la
                                                        huella de carbono
                                                        organizacional del año
                                                        base?
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
                                                        >¿Se obtuvo la
                                                        declaración de
                                                        conformidad asociada en
                                                        el proceso de
                                                        verificación por parte
                                                        del tercero?
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
                                                        poder cumplir con todos
                                                        los requisitos del
                                                        proceso?
                                                    </label>
                                                    <Multiselect
                                                        v-model="
                                                            ie.acciones_mejora
                                                        "
                                                        :options="options_si_no"
                                                        placeholder="Seleccione una opción"
                                                        required
                                                    />
                                                </div>
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
                                                        ie.anio_proyeccion_meta =
                                                            null;
                                                        ie.meta_alineada = null;
                                                        ie.metodologia = null;
                                                        ie.otra_metodologia =
                                                            null;
                                                        ie.seguimiento_cumplimiento =
                                                            null;
                                                    "
                                                />
                                            </div>
                                            <div v-if="ie.anio_meta">
                                                <div class="mb-3">
                                                    <label class="required"
                                                        >¿A que año está
                                                        proyectada esta meta?
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
                                                        >¿La meta está alineada
                                                        con los compromisos
                                                        nacionales (NDC), con
                                                        las metas de reducción
                                                        del acuerdo de París y/o
                                                        con otro compromiso
                                                        sectorial o de otro
                                                        tipo?
                                                    </label>
                                                    <Multiselect
                                                        v-model="
                                                            ie.meta_alineada
                                                        "
                                                        :options="options_si_no"
                                                        placeholder="Seleccione una opción"
                                                        required
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label
                                                                class="required"
                                                                >¿Cuál de éstas
                                                                metodologías
                                                                empleó la
                                                                empresa en la
                                                                formulación de
                                                                la meta?
                                                            </label>
                                                            <Multiselect
                                                                v-model="
                                                                    ie.metodologia
                                                                "
                                                                :options="
                                                                    options_metodologia
                                                                "
                                                                valueProp="id"
                                                                label="nombre"
                                                                placeholder="Seleccione una opción"
                                                                required
                                                                @input="
                                                                    changeMetodologia()
                                                                "
                                                            />
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label
                                                                :class="
                                                                    valor_option_metodologia
                                                                        ? 'required'
                                                                        : ''
                                                                "
                                                                >Otra ¿Cuál?
                                                            </label>
                                                            <input
                                                                v-model="
                                                                    ie.otra_metodologia
                                                                "
                                                                type="text"
                                                                class="form-control"
                                                                :required="
                                                                    valor_option_metodologia
                                                                "
                                                                :disabled="
                                                                    !valor_option_metodologia
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="required"
                                                        >¿Se ha realizado algún
                                                        seguimiento al
                                                        cumplimiento de la meta
                                                        o se cuenta con un plan
                                                        de monitoreo asociado?
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
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-6 text-start"
                                                >
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        @click="
                                                            paso =
                                                                ie.huella_base ==
                                                                0
                                                                    ? (paso = 2)
                                                                    : 3
                                                        "
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
                                                    :options="options_puntaje_1"
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
                                                        type="submit"
                                                        class="btn btn-primary"
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
                        <form @submit.prevent="guardarProcesos">
                            <div class="mb-3">
                                <div class="accordion" id="acordeon-procesos">
                                    <div
                                        class="accordion-item"
                                        v-for="(p, ip) in procesos"
                                        v-bind:key="ip"
                                    >
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                :data-bs-target="
                                                    '#panelsStayOpen-collapse-' +
                                                    ip
                                                "
                                                aria-expanded="true"
                                                :aria-controls="
                                                    'panelsStayOpen-collapse-' +
                                                    ip
                                                "
                                            >
                                                {{ p.nombre }}
                                            </button>
                                        </h2>

                                        <div
                                            :id="
                                                'panelsStayOpen-collapse-' + ip
                                            "
                                            class="accordion-collapse collapse show"
                                            :aria-labelledby="
                                                'panelsStayOpen-heading-' + ip
                                            "
                                        >
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label required"
                                                        >Nombre del
                                                        proceso</label
                                                    >
                                                    <input
                                                        v-model="p.nombre"
                                                        type="text"
                                                        class="form-control"
                                                    />
                                                </div>
                                                <div class="mb-3">
                                                    <div
                                                        class="accordion"
                                                        id="accordionSubprocesos"
                                                    >
                                                        <div
                                                            class="accordion-item"
                                                            v-for="(
                                                                sp, is
                                                            ) in p.subprocesos"
                                                            v-bind:key="is"
                                                        >
                                                            <h2
                                                                class="accordion-header"
                                                                id="flush-headingOne"
                                                            >
                                                                <button
                                                                    class="accordion-button collapsed"
                                                                    type="button"
                                                                    data-bs-toggle="collapse"
                                                                    :data-bs-target="
                                                                        '#flush-collapse' +
                                                                        ip +
                                                                        is
                                                                    "
                                                                    aria-expanded="false"
                                                                    :aria-controls="
                                                                        'flush-collapse' +
                                                                        ip +
                                                                        is
                                                                    "
                                                                >
                                                                    {{
                                                                        sp.nombre
                                                                    }}
                                                                </button>
                                                            </h2>
                                                            <div
                                                                :id="
                                                                    'flush-collapse' +
                                                                    ip +
                                                                    is
                                                                "
                                                                class="accordion-collapse collapse"
                                                                :aria-labelledby="
                                                                    'flush-heading' +
                                                                    ip +
                                                                    is
                                                                "
                                                                data-bs-parent="#accordionSubprocesos"
                                                            >
                                                                <div
                                                                    class="accordion-body"
                                                                >
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Nombre
                                                                            del
                                                                            sub
                                                                            proceso</label
                                                                        >
                                                                        <input
                                                                            v-model="
                                                                                sp.nombre
                                                                            "
                                                                            type="text"
                                                                            class="form-control"
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Descripción</label
                                                                        >
                                                                        <textarea
                                                                            v-model="
                                                                                sp.descripcion
                                                                            "
                                                                            class="form-control"
                                                                            required
                                                                        ></textarea>
                                                                    </div>

                                                                    <h2>
                                                                        Fuentes
                                                                        fijas
                                                                    </h2>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            combustibles
                                                                            sólidos</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Combustible_solido
                                                                            "
                                                                            :options="
                                                                                options_combustible_solido
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Combustible_solido.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Combustible_solido =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            combustibles
                                                                            líquidos</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Combustible_liquido
                                                                            "
                                                                            :options="
                                                                                options_combustible_liquido
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Combustible_liquido.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Combustible_liquido =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            combustibles
                                                                            gaseosos</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Combustible_gaseoso
                                                                            "
                                                                            :options="
                                                                                options_combustible_gaseoso
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Combustible_gaseoso.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Combustible_gaseoso =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            refrigerantes</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Refrigerante
                                                                            "
                                                                            :options="
                                                                                options_refrigerante
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Refrigerante.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Refrigerante =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Extintores</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Extintor
                                                                            "
                                                                            :options="
                                                                                options_extintor
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Extintor.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Extintor =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Lubricantes</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Lubricante
                                                                            "
                                                                            :options="
                                                                                options_lubricante
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Lubricante.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Lubricante =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Fugas
                                                                            de
                                                                            CO2
                                                                            en
                                                                            proceso</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Fuga
                                                                            "
                                                                            :options="
                                                                                options_fuga
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Fuga.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Fuga =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            aislante
                                                                            eléctrico
                                                                        </label>
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_fijas
                                                                                    .Aislamiento
                                                                            "
                                                                            :options="
                                                                                options_aislamiento
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_fijas.Aislamiento.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.Aislamiento =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>

                                                                    <h2>
                                                                        Emisiones
                                                                        de
                                                                        proceso
                                                                    </h2>

                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Manejo
                                                                            de
                                                                            embalses</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .emisiones
                                                                                    .Embalse
                                                                            "
                                                                            :options="
                                                                                options_embalse
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.emisiones.Embalse.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.Embalse =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Minería</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .emisiones
                                                                                    .Mineria
                                                                            "
                                                                            :options="
                                                                                options_mineria
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.emisiones.Mineria.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.Mineria =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Industrial</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .emisiones
                                                                                    .Industrial
                                                                            "
                                                                            :options="
                                                                                options_industrial
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.emisiones.Industrial.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.Industrial =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Fermentación
                                                                            entérica</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .emisiones
                                                                                    .Fermentacion
                                                                            "
                                                                            :options="
                                                                                options_fermentacion
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.emisiones.Fermentacion.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.Fermentacion =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Manejo
                                                                            de
                                                                            estiércol</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .emisiones
                                                                                    .Estiercol
                                                                            "
                                                                            :options="
                                                                                options_estiercol
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.emisiones.Estiercol.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.Estiercol =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Manejo
                                                                            Residuos
                                                                            Organizacionales
                                                                        </label>
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .emisiones
                                                                                    .Residuo_organizacional
                                                                            "
                                                                            :options="
                                                                                options_residuo_organizacional
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.emisiones.Residuo_organizacional.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.Residuo_organizacional =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>

                                                                    <h2>
                                                                        Fuentes
                                                                        móviles
                                                                    </h2>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            combustibles
                                                                            líquidos</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_moviles
                                                                                    .Combustible_liquido
                                                                            "
                                                                            :options="
                                                                                options_combustible_liquido
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_moviles.Combustible_liquido.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.Combustible_liquido =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            combustibles
                                                                            gaseosos</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_moviles
                                                                                    .Combustible_gaseoso
                                                                            "
                                                                            :options="
                                                                                options_combustible_gaseoso
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_moviles.Combustible_gaseoso.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.Combustible_gaseoso =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>

                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Consumo
                                                                            de
                                                                            refrigerantes</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_moviles
                                                                                    .Refrigerante
                                                                            "
                                                                            :options="
                                                                                options_refrigerante
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_moviles.Refrigerante.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.Refrigerante =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Extintores</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_moviles
                                                                                    .Extintor
                                                                            "
                                                                            :options="
                                                                                options_extintor
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_moviles.Extintor.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.Extintor =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Lubricantes</label
                                                                        >
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .fuentes_moviles
                                                                                    .Lubricante
                                                                            "
                                                                            :options="
                                                                                options_lubricante
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.fuentes_moviles.Lubricante.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.Lubricante =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>

                                                                    <h2>
                                                                        Agrícolas
                                                                    </h2>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Manejo
                                                                            de
                                                                            residuos
                                                                            agropecuarios
                                                                        </label>
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .agricolas
                                                                                    .Residuo_agropecuario
                                                                            "
                                                                            :options="
                                                                                options_residuo_agropecuario
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.agricolas.Residuo_agropecuario.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.agricolas.Residuo_agropecuario =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Uso
                                                                            fertilizantes
                                                                        </label>
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .agricolas
                                                                                    .Fertilizante
                                                                            "
                                                                            :options="
                                                                                options_fertilizante
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.agricolas.Fertilizante.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.agricolas.Fertilizante =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="mb-3"
                                                                    >
                                                                        <label
                                                                            class="required"
                                                                            >Cal
                                                                            aplicada
                                                                        </label>
                                                                        <Multiselect
                                                                            v-model="
                                                                                sp
                                                                                    .agricolas
                                                                                    .Cal
                                                                            "
                                                                            :options="
                                                                                options_cal
                                                                            "
                                                                            mode="tags"
                                                                            valueProp="id"
                                                                            label="nombre"
                                                                            placeholder="Selección múltiple"
                                                                            :searchable="
                                                                                true
                                                                            "
                                                                            required
                                                                            @input="
                                                                                if (
                                                                                    sp.agricolas.Cal.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.agricolas.Cal =
                                                                                        [
                                                                                            -1,
                                                                                        ];
                                                                            "
                                                                        />
                                                                    </div>

                                                                    <div
                                                                        class="mb-3 text-end"
                                                                    >
                                                                        <button
                                                                            v-if="
                                                                                is >
                                                                                0
                                                                            "
                                                                            type="button"
                                                                            class="btn btn-danger"
                                                                            @click="
                                                                                if (
                                                                                    is >
                                                                                    0
                                                                                )
                                                                                    procesos[
                                                                                        ip
                                                                                    ][
                                                                                        'subprocesos'
                                                                                    ].splice(
                                                                                        is,
                                                                                        1
                                                                                    );
                                                                            "
                                                                        >
                                                                            Eliminar
                                                                            subproceso
                                                                        </button>

                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-success"
                                                                            @click="
                                                                                procesos[
                                                                                    ip
                                                                                ][
                                                                                    'subprocesos'
                                                                                ].splice(
                                                                                    is +
                                                                                        1,
                                                                                    0,
                                                                                    {
                                                                                        nombre: 'Nuevo subproceso',
                                                                                        descripcion:
                                                                                            '',
                                                                                        fuentes_fijas:
                                                                                            {
                                                                                                Combustible_solido:
                                                                                                    [],
                                                                                                Combustible_liquido:
                                                                                                    [],
                                                                                                Combustible_gaseoso:
                                                                                                    [],
                                                                                                Refrigerante:
                                                                                                    [],
                                                                                                Extintor:
                                                                                                    [],
                                                                                                Lubricante:
                                                                                                    [],
                                                                                                Fuga: [],
                                                                                                aislamientos:
                                                                                                    [],
                                                                                            },
                                                                                        fuentes_moviles:
                                                                                            {
                                                                                                Combustible_liquido:
                                                                                                    [],
                                                                                                Combustible_gaseoso:
                                                                                                    [],
                                                                                                Refrigerante:
                                                                                                    [],
                                                                                                Extintor:
                                                                                                    [],
                                                                                                Lubricante:
                                                                                                    [],
                                                                                            },
                                                                                        emisiones:
                                                                                            {
                                                                                                Embalse:
                                                                                                    [],
                                                                                                Mineria:
                                                                                                    [],
                                                                                                Industrial:
                                                                                                    [],
                                                                                                Fermentacion:
                                                                                                    [],
                                                                                                Estiercol:
                                                                                                    [],
                                                                                                Residuo_organizacional:
                                                                                                    [],
                                                                                            },
                                                                                        agricolas:
                                                                                            {
                                                                                                Residuo_agropecuario:
                                                                                                    [],
                                                                                                Fertilizante:
                                                                                                    [],
                                                                                                Cal: [],
                                                                                            },
                                                                                    }
                                                                                )
                                                                            "
                                                                        >
                                                                            Agregar
                                                                            subproceso
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 text-end">
                                                    <button
                                                        v-if="ip > 0"
                                                        type="button"
                                                        class="btn btn-danger"
                                                        @click="
                                                            if (ip > 0)
                                                                procesos.splice(
                                                                    ip,
                                                                    1
                                                                );
                                                        "
                                                    >
                                                        Eliminar proceso
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="btn btn-success"
                                                        @click="
                                                            procesos.splice(
                                                                ip + 1,
                                                                0,
                                                                {
                                                                    nombre: 'Nuevo proceso',
                                                                    subprocesos:
                                                                        [
                                                                            {
                                                                                nombre: 'Nuevo subproceso',
                                                                                descripcion:
                                                                                    '',
                                                                                fuentes_fijas:
                                                                                    {
                                                                                        Combustible_solido:
                                                                                            [],
                                                                                        Combustible_liquido:
                                                                                            [],
                                                                                        Combustible_gaseoso:
                                                                                            [],
                                                                                        Refrigerante:
                                                                                            [],
                                                                                        Extintor:
                                                                                            [],
                                                                                        Lubricante:
                                                                                            [],
                                                                                        Fuga: [],
                                                                                        aislamientos:
                                                                                            [],
                                                                                    },
                                                                                fuentes_moviles:
                                                                                    {
                                                                                        Combustible_liquido:
                                                                                            [],
                                                                                        Combustible_gaseoso:
                                                                                            [],
                                                                                        Refrigerante:
                                                                                            [],
                                                                                        Extintor:
                                                                                            [],
                                                                                        Lubricante:
                                                                                            [],
                                                                                    },
                                                                                emisiones:
                                                                                    {
                                                                                        Embalse:
                                                                                            [],
                                                                                        Mineria:
                                                                                            [],
                                                                                        Industrial:
                                                                                            [],
                                                                                        Fermentacion:
                                                                                            [],
                                                                                        Estiercol:
                                                                                            [],
                                                                                        Residuo_organizacional:
                                                                                            [],
                                                                                    },
                                                                                agricolas:
                                                                                    {
                                                                                        Residuo_agropecuario:
                                                                                            [],
                                                                                        Fertilizante:
                                                                                            [],
                                                                                        Cal: [],
                                                                                    },
                                                                            },
                                                                        ],
                                                                }
                                                            )
                                                        "
                                                    >
                                                        Agregar proceso
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="inicio-consumos"
                        role="tabpanel"
                        aria-labelledby="inicio-consumos-tab"
                    >
                        <form @submit.prevent="guardarInicioConsumo">
                            <div class="mb-3">
                                <label class="required"
                                    >Unidad principal de producción y/o
                                    servicios de la empresa</label
                                >
                                <Multiselect
                                    v-model="ie.unidad_id"
                                    :options="options_unidad"
                                    valueProp="id"
                                    label="nombre"
                                    placeholder="Seleccione una opción"
                                    :searchable="true"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >Año de incio de consumos</label
                                >
                                <Multiselect
                                    v-model="ie.anio_inicio"
                                    :options="options_anio"
                                    valueProp="valor"
                                    label="nombre"
                                    placeholder="Seleccione una opción"
                                    :searchable="true"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >Mes de incio de consumos</label
                                >
                                <Multiselect
                                    v-model="ie.mes_inicio"
                                    :options="options_mes"
                                    valueProp="valor"
                                    label="nombre"
                                    placeholder="Seleccione una opción"
                                    :searchable="true"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="consumos-indirectos"
                        role="tabpanel"
                        aria-labelledby="consumos-indirectos-tab"
                    >
                        <form @submit.prevent="guardarEmisionesIndirectas">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <b>
                                        EMISIONES INDIRECTAS DE GEI CAUSADAS POR
                                        ENERGÍA IMPORTADA
                                    </b>
                                </div>
                                <div class="card-body">
                                    <p>ELECTRICIDAD IMPORTADA</p>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de energía eléctrica</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.energias
                                                    .Energia_electrica
                                            "
                                            :options="options_electricidad"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.energias.Energia_electrica.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.energias.Energia_electrica =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <p>ENERGÍA IMPORTADA</p>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de combustibles
                                            sólidos</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.energias
                                                    .Combustible_solido
                                            "
                                            :options="
                                                options_combustible_solido
                                            "
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.energias.Combustible_solido.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.energias.Combustible_solido =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de combustibles
                                            líquidos</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.energias
                                                    .Combustible_liquido
                                            "
                                            :options="
                                                options_combustible_liquido
                                            "
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.energias.Combustible_liquido.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.energias.Combustible_liquido =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de combustibles
                                            gaseosos</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.energias
                                                    .Combustible_gaseoso
                                            "
                                            :options="
                                                options_combustible_gaseoso
                                            "
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.energias.Combustible_gaseoso.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.energias.Combustible_gaseoso =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <b>
                                        EMISIONES INDIRECTAS DE GEI CAUSADAS POR
                                        EL TRANSPORTE
                                    </b>
                                </div>
                                <div class="card-body">
                                    <p>FUENTES MÓVILES</p>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de combustibles
                                            líquidos</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.transportes
                                                    .Combustible_liquido
                                            "
                                            :options="
                                                options_combustible_liquido
                                            "
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.transportes.Combustible_liquido.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.transportes.Combustible_liquido =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de combustibles
                                            gaseosos</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.transportes
                                                    .Combustible_gaseoso
                                            "
                                            :options="
                                                options_combustible_gaseoso
                                            "
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.transportes.Combustible_gaseoso.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.transportes.Combustible_gaseoso =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de refrigerantes</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.transportes
                                                    .Refrigerante
                                            "
                                            :options="options_refrigerante"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.transportes.Refrigerante.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.transportes.Refrigerante =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Extintores</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.transportes
                                                    .Extintor
                                            "
                                            :options="options_extintor"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.transportes.Extintor.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.transportes.Extintor =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Lubricantes</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.transportes
                                                    .Lubricante
                                            "
                                            :options="options_lubricante"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.transportes.Lubricante.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.transportes.Lubricante =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <p>TRANSPORTE CARGA Y PASAJEROS</p>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Transporte de carga</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.transportes
                                                    .Transporte
                                            "
                                            :options="options_viaje"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.transportes.Transporte.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.transportes.Transporte =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <b>
                                        EMISIONES INDIRECTAS DE GEI CAUSADAS POR
                                        PRODUCTOS QUE UTILIZA LA ORGANIZACIÓN
                                    </b>
                                </div>
                                <div class="card-body">
                                    <p>BIENES Y PRODUCTOS</p>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Refrigerantes y espumantes (Fuentes
                                            fijas)</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.productos
                                                    .Refrigerante
                                            "
                                            :options="options_refrigerante"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.productos.Refrigerante.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.productos.Refrigerante =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Extintores (Fuentes fijas)</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.productos
                                                    .Extintor
                                            "
                                            :options="options_extintor"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.productos.Extintor.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.productos.Extintor =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Lubricantes (Fuentes
                                            móviles)</label
                                        >
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.productos
                                                    .Lubricante
                                            "
                                            :options="options_lubricante"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.productos.Lubricante.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.productos.Lubricante =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Consumo de aislante eléctrico
                                        </label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.productos
                                                    .Aislamiento
                                            "
                                            :options="options_aislamiento"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.productos.Aislamiento.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.productos.Aislamiento =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required">Equipos</label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.productos
                                                    .Equipo
                                            "
                                            :options="options_fuga"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.productos.Equipo.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.productos.Equipo =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Materias primas
                                        </label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.productos
                                                    .Materia_prima
                                            "
                                            :options="options_aislamiento"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.productos.Materia_prima.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.productos.Materia_prima =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                    <p>SERVICIOS</p>
                                    <div class="mb-3">
                                        <label class="required"
                                            >Manejo de residuos
                                        </label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.productos
                                                    .Residuo
                                            "
                                            :options="
                                                options_residuo_organizacional
                                            "
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.productos.Residuo.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.productos.Residuo =
                                                        [-1];
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <b>
                                        EMISIONES INDIRECTAS DE GEI ASOCIADAS
                                        CON EL USO DE LOS PRODUCTOS DE LA
                                        ORGANIZACIÓN
                                    </b>
                                </div>
                                <div class="card-body">
                                    <p>USO DE PRODUCTOS</p>
                                    <!-- Por revisar ya que todos los listados tienen
                                    la misma opción

                                    <div class="mb-3">
                                        <label class="required">Producto</label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.usos
                                                    .aislamientos
                                            "
                                            :options="options_aislamiento"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            required
                                            @input="
                                                if (
                                                    emisiones_indirectas.usos.aislamientos.includes(
                                                        -1
                                                    )
                                                )
                                                    emisiones_indirectas.usos.aislamientos =
                                                        [-1];
                                            "
                                        />
                                    </div> -->
                                    <p>FIN DE VIDA</p>
                                    <p>ACTIVOS ARRENDADOS</p>
                                    <p>INVERSIONES</p>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <b>
                                        EMISIONES INDIRECTAS DE GEI PROVENIENTES
                                        DE OTRAS FUENTES
                                    </b>
                                </div>
                                <div class="card-body">
                                    <p>OTROS</p>
                                </div>
                            </div>

                            <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="construccion-anio"
                        role="tabpanel"
                        aria-labelledby="construccion-anio-tab"
                    >
                        <p v-if="fuentes_emision.length > 0">
                            <b>
                                {{
                                    fuentes_emision[index_fuente_emision]
                                        .categoria_mostrar
                                }}
                            </b>
                        </p>
                        <div class="mb-3 table-responsive">
                            <table
                                class="table table-striped table-hover table-bordered"
                            >
                                <thead>
                                    <tr class="d-flex">
                                        <th
                                            v-for="(c, i) in cabecera_tabla"
                                            v-bind:key="i"
                                            style="width: 200px"
                                        >
                                            {{ c }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="d-flex"
                                        v-if="fuentes_emision.length > 0"
                                    >
                                        <td style="width: 200px">
                                            {{
                                                fuentes_emision[
                                                    index_fuente_emision
                                                ].subproceso != null
                                                    ? fuentes_emision[
                                                          index_fuente_emision
                                                      ].subproceso.proceso
                                                          .nombre
                                                    : "No aplica"
                                            }}
                                        </td>
                                        <td style="width: 200px">
                                            {{
                                                fuentes_emision[
                                                    index_fuente_emision
                                                ].subproceso != null
                                                    ? fuentes_emision[
                                                          index_fuente_emision
                                                      ].subproceso.nombre
                                                    : "No aplica"
                                            }}
                                        </td>
                                        <td style="width: 200px">
                                            {{
                                                fuentes_emision[
                                                    index_fuente_emision
                                                ].tipo_mostrar
                                            }}
                                        </td>
                                        <td style="width: 200px">
                                            {{
                                                fuentes_emision[
                                                    index_fuente_emision
                                                ].fuente_emision_mostrar
                                            }}
                                        </td>
                                        <td style="width: 200px">
                                            {{
                                                fuentes_emision[
                                                    index_fuente_emision
                                                ].fuentetable.nombre
                                            }}
                                        </td>
                                        <td style="width: 200px">
                                            {{
                                                fuentes_emision[
                                                    index_fuente_emision
                                                ].fuentetable.unidad_consumo
                                            }}
                                        </td>
                                        <td
                                            v-for="i in 12"
                                            v-bind:key="i"
                                            style="width: 200px"
                                        >
                                            <input
                                                v-model="
                                                    fuentes_emision[
                                                        index_fuente_emision
                                                    ]['dato_mes_' + i]
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 text-start">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    v-if="index_fuente_emision > 0"
                                    @click="index_fuente_emision--"
                                >
                                    Atrás
                                </button>
                            </div>
                            <div class="col-lg-6 text-end">
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="guardarDatosEmision()"
                                >
                                    Guardar y continuar
                                </button>
                            </div>
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
import Combustible from "../../models/Combustible";
import Refrigerante from "../../models/Refrigerante";
import Extintor from "../../models/Extintor";
import Lubricante from "../../models/Lubricante";
import Fuga from "../../models/Fuga";
import Aislamiento from "../../models/Aislamiento";
import Emision from "../../models/Emision";
import Fermentacion from "../../models/Fermentacion";
import Estiercol from "../../models/Estiercol";
import Fertilizante from "../../models/Fertilizante";
import Proceso from "../../models/Proceso";
import Electricidad from "../../models/Electricidad";
import Viaje from "../../models/Viaje";
import FuenteEmision from "../../models/FuenteEmision";

export default {
    data() {
        return {
            ie: new InformacionEmpresa({
                id: null,
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
                unidad_id: null,
                anio_inicio: null,
                mes_inicio: null,
                usuario_creacion_id: null,
                empresa_id: null,
                sede_id: null,
            }),

            fuente_emision: new FuenteEmision({
                id: "",
                dato_mes_1: "",
                dato_mes_2: "",
                dato_mes_3: "",
                dato_mes_4: "",
                dato_mes_5: "",
                dato_mes_6: "",
                dato_mes_7: "",
                dato_mes_8: "",
                dato_mes_9: "",
                dato_mes_10: "",
                dato_mes_11: "",
                dato_mes_12: "",
            }),

            paso: 1,
            emisiones_indirectas: {
                energias: {
                    energia_electrica: [],
                    Combustible_solido: [],
                    Combustible_liquido: [],
                    Combustible_gaseoso: [],
                },
                transportes: {
                    Combustible_solido: [],
                    Combustible_liquido: [],
                    Combustible_gaseoso: [],
                    Refrigerante: [],
                    Extintor: [],
                    Lubricantes: [],
                    Transporte: [],
                },
                productos: {
                    Refrigerante: [],
                    Extintore: [],
                    Lubricante: [],
                    Aislamiento: [],
                    Equipo: [],
                    Materia_prima: [],
                    Residuo: [],
                },
                usos: {},
                otros: {},
            },
            procesos: [
                {
                    nombre: "Proceso 1",
                    subprocesos: [
                        {
                            nombre: "Subproceso 1",
                            descripcion: "",
                            fuentes_fijas: {
                                Combustible_solido: [],
                                Combustible_liquido: [],
                                Combustible_gaseoso: [],
                                Refrigerante: [],
                                Extintor: [],
                                Lubricante: [],
                                Fuga: [],
                                Aislamiento: [],
                            },
                            fuentes_moviles: {
                                Combustible_liquido: [],
                                Combustible_gaseoso: [],
                                Refrigerante: [],
                                Extintor: [],
                                Lubricante: [],
                            },
                            emisiones: {
                                Embalse: [],
                                Mineria: [],
                                Industrial: [],
                                Fermentacion: [],
                                Estiercol: [],
                                Residuos_organizacionales: [],
                            },
                            agricolas: {
                                Residuos_agropecuarios: [],
                                Fertilizant: [],
                                Cal: [],
                            },
                        },
                    ],
                },
            ],
            fuentes_emision: [],
            index_fuente_emision: 0,
            total_fuentes_emision: "",

            valor_option_metodologia: "",

            fecha_base: "",

            cabecera_tabla: [],

            array_meses: [
                "ENERO",
                "FEBRERO",
                "MARZO",
                "ABRIL",
                "MAYO",
                "JUNIO",
                "JULIO",
                "AGOSTO",
                "SEPTIEMBRE",
                "OCTUBRE",
                "NOVIEMBRE",
                "DICIEMBRE",
            ],

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

            option_ninguna: { id: -1, nombre: "Ninguno" },

            options_combustible_solido: [],
            options_combustible_liquido: [],
            options_combustible_gaseoso: [],
            options_refrigerante: [],
            options_extintor: [],
            options_lubricante: [],
            options_fuga: [],
            options_aislamiento: [],
            options_embalse: [],
            options_mineria: [],
            options_industrial: [],
            options_fermentacion: [],
            options_estiercol: [],
            options_residuo_organizacional: [],
            options_residuo_agropecuario: [],
            options_fertilizante: [],
            options_cal: [],
            options_electricidad: [],
            options_viaje: [],
            options_unidad: [],
            options_equipo_consumo: [],
            options_metodologia: [],
            options_anio: [],
            options_mes: [],
            required: "Este campo es requerido",
        };
    },
    mounted() {
        // this.getInformacionEmpresa();
        this.getParametros(7, "options_anio");
        this.getParametros(8, "options_mes");
        this.getParametros(12, "options_metodologia");
        this.getParametros(13, "options_unidad");
        this.getOptionsFuenteEmision();
    },
    methods: {
        async getParametros(tipo_parametro_id, variable) {
            //1 departamentos
            //3 sectores
            //4 CIIUs
            //5 tamaños de empresa
            //6 número de empleados
            //12 metodologías
            //13 Unidad producción y/o servicios

            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },
        async getOptionsFuenteEmision() {
            let array_options = [
                "options_combustible_solido",
                "options_combustible_liquido",
                "options_combustible_gaseoso",
                "options_refrigerante",
                "options_extintor",
                "options_lubricante",
                "options_fuga",
                "options_aislamiento",
                "options_embalse",
                "options_mineria",
                "options_industrial",
                "options_fermentacion",
                "options_estiercol",
                "options_residuo_organizacional",
                "options_residuo_agropecuario",
                "options_fertilizante",
                "options_cal",
                "options_electricidad",
                "options_viaje",
            ];

            this.options_combustible_solido = await Combustible.where(
                "tipo",
                "solido"
            ).get();

            this.options_combustible_liquido = await Combustible.where(
                "tipo",
                "liquido"
            ).get();

            this.options_combustible_gaseoso = await Combustible.where(
                "tipo",
                "gaseoso"
            ).get();

            this.options_refrigerante = await Refrigerante.get();
            this.options_extintor = await Extintor.get();
            this.options_lubricante = await Lubricante.get();
            this.options_fuga = await Fuga.get();
            this.options_aislamiento = await Aislamiento.get();

            this.options_embalse = await Emision.where("tipo", "Embalse").get();
            this.options_mineria = await Emision.where("tipo", "Mineria").get();
            this.options_industrial = await Emision.where(
                "tipo",
                "Industrial"
            ).get();
            this.options_residuo_organizacional = await Emision.where(
                "tipo",
                "Residuo"
            ).get();

            this.options_fermentacion = await Fermentacion.get();

            this.options_estiercol = await Estiercol.where(
                "tipo",
                "Estiercol"
            ).get();

            this.options_residuo_agropecuario = await Estiercol.where(
                "tipo",
                "Residuo"
            ).get();

            this.options_fertilizante = await Fertilizante.where(
                "tipo",
                "Fertilizante"
            ).get();

            this.options_cal = await Fertilizante.where("tipo", "Cal").get();

            this.options_electricidad = await Electricidad.get();
            this.options_viaje = await Viaje.get();

            array_options.forEach((e) => {
                this[e].push(this.option_ninguna);
                this[e].sort((a, b) => {
                    return a.id - b.id;
                });
            });
        },
        async getInformacionEmpresa() {
            // this.ie = await InformacionEmpresa.where({
            //     empresa_id: 1,
            //     sede_id: 1,
            // }).get();
        },
        changeMetodologia() {
            this.ie.otra_metodologia = null;
            let option = this.options_metodologia.filter(
                (el) => el.id === this.ie.metodologia
            );
            this.valor_option_metodologia = option[0]["valor"];
        },

        async guardarInformacion(e) {
            if (this.paso == 2) {
                if (this.ie.huella_base == 0) {
                    this.paso = 4;
                } else {
                    this.paso++;
                }
            } else {
                this.paso++;
            }

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
        guardarEmisionesIndirectas() {
            this.$root.mostrarCargando("Guardando información");
            axios
                .post("/api/guardarEmisionesIndirectas", {
                    emisiones: this.emisiones_indirectas,
                })
                .then((response) => {
                    Swal.close();
                    this.$root.mostrarMensaje(
                        "Éxito",
                        "Información guardada exitosamente",
                        "success"
                    );
                    this.limpiarFormularioEmisiones();
                })
                .catch((error) => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de la persona, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },

        async guardarProcesos() {
            this.$root.mostrarCargando("Guardando información");
            axios
                .post("/api/guardarProcesos", {
                    procesos: this.procesos,
                })
                .then((response) => {
                    Swal.close();
                    this.$root.mostrarMensaje(
                        "Éxito",
                        "Información guardada exitosamente",
                        "success"
                    );
                    this.limpiarFormularioProceso();
                })
                .catch((error) => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de la persona, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        async guardarDatosEmision() {
            this.$root.mostrarCargando("Guardando información");
            this.fuente_emision.id =
                this.fuentes_emision[this.index_fuente_emision].id;
            this.fuente_emision.dato_mes_1 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_1;
            this.fuente_emision.dato_mes_2 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_2;
            this.fuente_emision.dato_mes_3 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_3;
            this.fuente_emision.dato_mes_4 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_4;
            this.fuente_emision.dato_mes_5 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_5;
            this.fuente_emision.dato_mes_6 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_6;
            this.fuente_emision.dato_mes_7 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_7;
            this.fuente_emision.dato_mes_8 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_8;
            this.fuente_emision.dato_mes_9 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_9;
            this.fuente_emision.dato_mes_10 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_10;
            this.fuente_emision.dato_mes_11 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_11;
            this.fuente_emision.dato_mes_12 =
                this.fuentes_emision[this.index_fuente_emision].dato_mes_12;

            await this.fuente_emision.save();

            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                "Información guardada exitosamente",
                "success"
            );

            setTimeout(() => {
                if (this.index_fuente_emision < this.total_fuentes_emision) {
                    this.index_fuente_emision++;
                }
            }, 1500);
        },

        async getFuentesEmision() {
            this.$root.mostrarCargando("consultado información");

            this.fuentes_emision = await FuenteEmision.where({
                empresa_id: 1,
                sede_id: 1,
            })
                .include("subproceso", "subproceso.proceso", "fuentetable")
                .orderBy("id")
                .get();

            this.index_fuente_emision = 0;
            this.total_fuentes_emision = this.fuentes_emision.length - 1;
            this.tablaEmisiones();

            Swal.close();
        },

        async guardarInicioConsumo() {
            this.$root.mostrarCargando("Guardando información");

            let informacion_empresa = await InformacionEmpresa.where({
                empresa_id: 1,
                sede_id: 1,
            }).first();

            informacion_empresa.unidad_id = this.ie.unidad_id;
            informacion_empresa.anio_inicio = this.ie.anio_inicio;
            informacion_empresa.mes_inicio = this.ie.mes_inicio;
            await informacion_empresa.save();

            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                "Información guardada exitosamente",
                "success"
            );
        },

        async tablaEmisiones() {
            let informacion_empresa = await InformacionEmpresa.where({
                empresa_id: 1,
                sede_id: 1,
            }).first();

            this.cabecera_tabla = [
                "PROCESO",
                "SUBPROCESO",
                "SUBCATERGORÍA",
                "CLASE",
                "FUENTE DE EMISIÓN DE GEI",
                "UNIDAD",
            ];
            this.fecha_base = new Date(
                informacion_empresa.anio_inicio +
                    "-" +
                    informacion_empresa.mes_inicio +
                    "-01 00:00"
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
                    "DATO MES " + (i + 1) + " (" + month + " " + year + ")"
                );
            }
        },

        limpiarFormularioProceso() {
            this.procesos = [
                {
                    nombre: "Proceso 1",
                    subprocesos: [
                        {
                            nombre: "Subproceso 1",
                            descripcion: "",
                            fuentes_fijas: {
                                Combustible_solido: [],
                                Combustible_liquido: [],
                                Combustible_gaseoso: [],
                                Refrigerante: [],
                                Extintor: [],
                                Lubricante: [],
                                Fuga: [],
                                Aislamiento: [],
                            },
                            fuentes_moviles: {
                                Combustible_liquido: [],
                                Combustible_gaseoso: [],
                                Refrigerante: [],
                                Extintor: [],
                                Lubricante: [],
                            },
                            emisiones: {
                                Embalse: [],
                                Mineria: [],
                                Industrial: [],
                                Fermentacion: [],
                                Estiercol: [],
                                Residuos_organizacionales: [],
                            },
                            agricolas: {
                                Residuos_agropecuarios: [],
                                Fertilizant: [],
                                Cal: [],
                            },
                        },
                    ],
                },
            ];
        },

        limpiarFormularioEmisiones() {
            this.emisiones_indirectas = {
                energias: {
                    energia_electrica: [],
                    Combustible_solido: [],
                    Combustible_liquido: [],
                    Combustible_gaseoso: [],
                },
                transportes: {
                    Combustible_solido: [],
                    Combustible_liquido: [],
                    Combustible_gaseoso: [],
                    Refrigerante: [],
                    Extintor: [],
                    Lubricantes: [],
                    Transporte: [],
                },
                productos: {
                    Refrigerante: [],
                    Extintore: [],
                    Lubricante: [],
                    Aislamiento: [],
                    Equipo: [],
                    Materia_prima: [],
                    Residuo: [],
                },
                usos: {},
                otros: {},
            };
        },
    },
};
</script>
<style>
textarea.form-control {
    max-height: 80px;
    min-height: 80px;
}
.input-width {
    width: 180px;
}
</style>
;
