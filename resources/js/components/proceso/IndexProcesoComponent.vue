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
                        <form @submit.prevent="submitInformacion">
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
                        <form @submit.prevent="submitProcesos">
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
                                                                                    .combustibles_solidos
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
                                                                                    sp.fuentes_fijas.combustibles_solidos.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.combustibles_solidos =
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
                                                                                    .combustibles_liquidos
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
                                                                                    sp.fuentes_fijas.combustibles_liquidos.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.combustibles_liquidos =
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
                                                                                    .combustibles_gaseosos
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
                                                                                    sp.fuentes_fijas.combustibles_gaseosos.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.combustibles_gaseosos =
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
                                                                                    .refrigerantes
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
                                                                                    sp.fuentes_fijas.refrigerantes.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.refrigerantes =
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
                                                                                    .extintores
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
                                                                                    sp.fuentes_fijas.extintores.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.extintores =
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
                                                                                    .lubricantes
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
                                                                                    sp.fuentes_fijas.lubricantes.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.lubricantes =
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
                                                                                    .fugas
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
                                                                                    sp.fuentes_fijas.fugas.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.fugas =
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
                                                                                    .aislamientos
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
                                                                                    sp.fuentes_fijas.aislamientos.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_fijas.aislamientos =
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
                                                                                    .embalses
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
                                                                                    sp.emisiones.embalses.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.embalses =
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
                                                                                    .minerias
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
                                                                                    sp.emisiones.minerias.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.minerias =
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
                                                                                    .industriales
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
                                                                                    sp.emisiones.industriales.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.industriales =
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
                                                                                    .fermentaciones
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
                                                                                    sp.emisiones.fermentaciones.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.fermentaciones =
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
                                                                                    .estiercoles
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
                                                                                    sp.emisiones.estiercoles.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.estiercoles =
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
                                                                                    .residuos_organizacionales
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
                                                                                    sp.emisiones.residuos_organizacionales.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.emisiones.residuos_organizacionales =
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
                                                                                    .combustibles_liquidos
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
                                                                                    sp.fuentes_moviles.combustibles_liquidos.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.combustibles_liquidos =
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
                                                                                    .combustibles_gaseosos
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
                                                                                    sp.fuentes_moviles.combustibles_gaseosos.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.combustibles_gaseosos =
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
                                                                                    .refrigerantes
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
                                                                                    sp.fuentes_moviles.refrigerantes.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.refrigerantes =
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
                                                                                    .extintores
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
                                                                                    sp.fuentes_moviles.extintores.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.extintores =
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
                                                                                    .lubricantes
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
                                                                                    sp.fuentes_moviles.lubricantes.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.fuentes_moviles.lubricantes =
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
                                                                                    .residuos_agropecuarios
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
                                                                                    sp.agricolas.residuos_agropecuarios.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.agricolas.residuos_agropecuarios =
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
                                                                                    .fertilizantes
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
                                                                                    sp.agricolas.fertilizantes.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.agricolas.fertilizantes =
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
                                                                                    .cales
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
                                                                                    sp.agricolas.cales.includes(
                                                                                        -1
                                                                                    )
                                                                                )
                                                                                    sp.agricolas.cales =
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
                                                                                                combustibles_solidos:
                                                                                                    [],
                                                                                                combustibles_liquidos:
                                                                                                    [],
                                                                                                combustibles_gaseosos:
                                                                                                    [],
                                                                                                refrigerantes:
                                                                                                    [],
                                                                                                extintores:
                                                                                                    [],
                                                                                                lubricantes:
                                                                                                    [],
                                                                                                fugas: [],
                                                                                                aislamientos:
                                                                                                    [],
                                                                                            },
                                                                                        fuentes_moviles:
                                                                                            {
                                                                                                combustibles_liquidos:
                                                                                                    [],
                                                                                                combustibles_gaseosos:
                                                                                                    [],
                                                                                                refrigerantes:
                                                                                                    [],
                                                                                                extintores:
                                                                                                    [],
                                                                                                lubricantes:
                                                                                                    [],
                                                                                            },
                                                                                        emisiones:
                                                                                            {
                                                                                                embalses:
                                                                                                    [],
                                                                                                minerias:
                                                                                                    [],
                                                                                                industriales:
                                                                                                    [],
                                                                                                fermentaciones:
                                                                                                    [],
                                                                                                estiercoles:
                                                                                                    [],
                                                                                                residuos_organizacionales:
                                                                                                    [],
                                                                                            },
                                                                                        agricolas:
                                                                                            {
                                                                                                residuos_agropecuarios:
                                                                                                    [],
                                                                                                fertilizantes:
                                                                                                    [],
                                                                                                cales: [],
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
                                                                                nombre: 'Subproceso 1',
                                                                                descripcion:
                                                                                    '',
                                                                                fuentes_fijas:
                                                                                    {
                                                                                        combustibles_solidos:
                                                                                            [],
                                                                                        combustibles_liquidos:
                                                                                            [],
                                                                                        combustibles_gaseosos:
                                                                                            [],
                                                                                        refrigerantes:
                                                                                            [],
                                                                                        extintores:
                                                                                            [],
                                                                                        lubricantes:
                                                                                            [],
                                                                                        fugas: [],
                                                                                        aislamientos:
                                                                                            [],
                                                                                    },
                                                                                fuentes_moviles:
                                                                                    {
                                                                                        combustibles_liquidos:
                                                                                            [],
                                                                                        combustibles_gaseosos:
                                                                                            [],
                                                                                        refrigerantes:
                                                                                            [],
                                                                                        extintores:
                                                                                            [],
                                                                                        lubricantes:
                                                                                            [],
                                                                                    },
                                                                                emisiones:
                                                                                    {
                                                                                        embalses:
                                                                                            [],
                                                                                        minerias:
                                                                                            [],
                                                                                        industriales:
                                                                                            [],
                                                                                        fermentaciones:
                                                                                            [],
                                                                                        estiercoles:
                                                                                            [],
                                                                                        residuos_organizacionales:
                                                                                            [],
                                                                                    },
                                                                                agricolas:
                                                                                    {
                                                                                        residuos_agropecuarios:
                                                                                            [],
                                                                                        fertilizantes:
                                                                                            [],
                                                                                        cales: [],
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
                        id="construccion-anio"
                        role="tabpanel"
                        aria-labelledby="construccion-anio-tab"
                    >
                        <div class="mb-3 table-responsive">
                            CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>PROCESO</th>
                                        <th>SUBPROCESO</th>
                                        <th>SUBCATERGORÍA</th>
                                        <th>CLASE</th>
                                        <th>FUENTE DE EMISIÓN DE GEI</th>
                                        <th>UNIDAD</th>
                                        <th>DATO 1</th>
                                        <th>DATO 2</th>
                                        <th>DATO 3</th>
                                        <th>DATO 4</th>
                                        <th>DATO 5</th>
                                        <th>DATO 6</th>
                                        <th>DATO 7</th>
                                        <th>DATO 8</th>
                                        <th>DATO 9</th>
                                        <th>DATO 10</th>
                                        <th>DATO 11</th>
                                        <th>DATO 12</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- v-for="(f, i) in info_procesos"
                                        v-bind:key="i"
                                        v-if="i == numero_proceso" -->
                                    <tr>
                                        <td>
                                            {{
                                                info_procesos[numero_proceso]
                                                    .proceso
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                info_procesos[numero_proceso]
                                                    .subproceso
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                info_procesos[numero_proceso]
                                                    .tipo_mostrar
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                info_procesos[numero_proceso]
                                                    .fuente_emision_mostrar
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                info_procesos[numero_proceso]
                                                    .modelo == "combustibles"
                                                    ? info_procesos[
                                                          numero_proceso
                                                      ].combustible.nombre
                                                    : info_procesos[
                                                          numero_proceso
                                                      ].modelo ==
                                                      "refrigerantes"
                                                    ? info_procesos[
                                                          numero_proceso
                                                      ].refrigerante
                                                    : ""
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                info_procesos[numero_proceso]
                                                    .modelo == "combustibles"
                                                    ? info_procesos[
                                                          numero_proceso
                                                      ].combustible
                                                          .unidad_consumo
                                                    : ""
                                            }}
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_1
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_2
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_3
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_4
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_5
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_6
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_7
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_8
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_9
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_10
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_11
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                v-model="
                                                    info_procesos[
                                                        numero_proceso
                                                    ].dato_mes_12
                                                "
                                                class="form-control input-width"
                                                type="number"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3 text-end">
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
import FuenteEmision from "../../models/FuenteEmision";

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
            procesos: [
                {
                    nombre: "Proceso 1",
                    subprocesos: [
                        {
                            nombre: "Subproceso 1",
                            descripcion: "",
                            fuentes_fijas: {
                                combustibles_solidos: [],
                                combustibles_liquidos: [],
                                combustibles_gaseosos: [],
                                refrigerantes: [],
                                extintores: [],
                                lubricantes: [],
                                fugas: [],
                                aislamientos: [],
                            },
                            fuentes_moviles: {
                                combustibles_liquidos: [],
                                combustibles_gaseosos: [],
                                refrigerantes: [],
                                extintores: [],
                                lubricantes: [],
                            },
                            emisiones: {
                                embalses: [],
                                minerias: [],
                                industriales: [],
                                fermentaciones: [],
                                estiercoles: [],
                                residuos_organizacionales: [],
                            },
                            agricolas: {
                                residuos_agropecuarios: [],
                                fertilizantes: [],
                                cales: [],
                            },
                        },
                    ],
                },
            ],
            info_procesos: [],
            options_anio: [],
            options_mes: [],
            numero_proceso: 0,

            valor_option_metodologia: "",

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

            options_equipo_consumo: [],
            options_energeticos: [],
            options_metodologia: [],
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
        this.getProcesos();
        this.getParametros(3, "options_sector");
        this.getParametros(7, "options_anio");
        this.getParametros(8, "options_mes");
        this.getParametros(11, "options_energeticos");
        this.getParametros(12, "options_metodologia");

        this.getOptionsFuenteEmision();
        // this.getEquiposConsumo();
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

            array_options.forEach((e) => {
                this[e].push(this.option_ninguna);
                this[e].sort((a, b) => {
                    return a.id - b.id;
                });
            });
        },
        changeMetodologia() {
            this.ie.otra_metodologia = null;
            let option = this.options_metodologia.filter(
                (el) => el.id === this.ie.metodologia
            );
            this.valor_option_metodologia = option[0]["valor"];
        },

        async submitInformacion(e) {
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
        async submitProcesos() {
            axios
                .post("/api/guardarProcesos", {
                    procesos: this.procesos,
                })
                .then((response) => {})
                .catch((error) => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de la persona, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        async getProcesos() {
            let data = await Proceso.where({
                empresa_id: 1,
                sede_id: 1,
            })
                .include(
                    "subprocesos",
                    "subprocesos.fuentesEmision",
                    "subprocesos.fuentesEmision.combustible",
                    "subprocesos.fuentesEmision.refrigerante"
                )
                .get();

            data.forEach((e) => {
                e.subprocesos.forEach((se) => {
                    se.fuentes_emision.forEach((fe) => {
                        fe.proceso = e.nombre;
                        fe.subproceso = se.nombre;
                        this.info_procesos.push(fe);
                    });
                });
            });
        },

        async guardarDatosEmision() {
            this.fuente_emision.id = this.info_procesos[this.numero_proceso].id;
            this.fuente_emision.dato_mes_1 =
                this.info_procesos[this.numero_proceso].dato_mes_1;
            this.fuente_emision.dato_mes_2 =
                this.info_procesos[this.numero_proceso].dato_mes_2;
            this.fuente_emision.dato_mes_3 =
                this.info_procesos[this.numero_proceso].dato_mes_3;
            this.fuente_emision.dato_mes_4 =
                this.info_procesos[this.numero_proceso].dato_mes_4;
            this.fuente_emision.dato_mes_5 =
                this.info_procesos[this.numero_proceso].dato_mes_5;
            this.fuente_emision.dato_mes_6 =
                this.info_procesos[this.numero_proceso].dato_mes_6;
            this.fuente_emision.dato_mes_7 =
                this.info_procesos[this.numero_proceso].dato_mes_7;
            this.fuente_emision.dato_mes_8 =
                this.info_procesos[this.numero_proceso].dato_mes_8;
            this.fuente_emision.dato_mes_9 =
                this.info_procesos[this.numero_proceso].dato_mes_9;
            this.fuente_emision.dato_mes_10 =
                this.info_procesos[this.numero_proceso].dato_mes_10;
            this.fuente_emision.dato_mes_11 =
                this.info_procesos[this.numero_proceso].dato_mes_11;
            this.fuente_emision.dato_mes_12 =
                this.info_procesos[this.numero_proceso].dato_mes_12;

            await this.fuente_emision.save();

            this.numero_proceso++;
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
    // traer de base de datos todas las fila e ir pintadolas de a una
    // adicional agregar campo para saber a que listado pertenece, por ejemplo combustible liquido
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
