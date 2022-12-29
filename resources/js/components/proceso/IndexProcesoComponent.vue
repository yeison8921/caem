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
                <ul class="nav flex-column mb-3">
                    <li class="nav-item" role="presentation">
                        <button
                            class="btn btn-link nav-link active"
                            id="formulario-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#formulario"
                            type="button"
                            role="tab"
                            aria-controls="formulario"
                            aria-selected="true"
                        >
                            1. Formulario
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="btn btn-link nav-link"
                            id="construccion-proceso-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#construccion-proceso"
                            type="button"
                            role="tab"
                            aria-controls="construccion-proceso"
                            aria-selected="false"
                        >
                            2. Construcción del proceso productivo de la empresa
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="btn btn-link nav-link"
                            id="consumos-indirectos-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#consumos-indirectos"
                            type="button"
                            role="tab"
                            aria-controls="consumos-indirectos"
                            aria-selected="false"
                        >
                            3. Consumos indirectos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="btn btn-link nav-link"
                            id="consumos-transversales-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#consumos-transversales"
                            type="button"
                            role="tab"
                            aria-controls="consumos-transversales"
                            aria-selected="false"
                        >
                            4. Consumos transverslaes (de apoyo) en la
                            organización
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="btn btn-link nav-link"
                            id="inicio-consumos-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#inicio-consumos"
                            type="button"
                            role="tab"
                            aria-controls="inicio-consumos"
                            aria-selected="false"
                        >
                            5. Información inicio de consumos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="btn btn-link nav-link"
                            id="construccion-anio-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#construccion-anio"
                            type="button"
                            role="tab"
                            aria-controls="construccion-anio"
                            aria-selected="false"
                            @click="getFuentesEmision()"
                        >
                            6. Construcción de año base de emisiones de GEI
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
                        <form @submit.prevent="guardarInformacion">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Paso 1 -->
                                    <div v-if="paso == 1">
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La información que reportará
                                                para el cálculo de la huella de
                                                carbono incluye datos de sus
                                                proveedores?
                                            </label>
                                            <Multiselect
                                                v-model="ie.datos_proveedores"
                                                :options="options_si_no"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La empresa cuenta con fuentes
                                                móviles propiedad de la compañía
                                                o que la organización asume el
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
                                                >¿La empresa realiza algún tipo
                                                de actividad agrícola?
                                            </label>
                                            <Multiselect
                                                v-model="ie.actividad_agricola"
                                                :options="options_si_no"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                    </div>

                                    <!-- Paso 2 -->
                                    <div v-if="paso == 2">
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La empresa ha calculado su
                                                huella de carbono organizacional
                                                para un año base?
                                            </label>
                                            <Multiselect
                                                v-model="ie.huella_base"
                                                :options="options_si_no"
                                                placeholder="Seleccione una opción"
                                                required
                                                @input="
                                                    ie.valor_huella_base = null;
                                                    ie.huella_comparativo =
                                                        null;
                                                    ie.valor_huella_comparativo =
                                                        null;
                                                    ie.alcances_huella = null;
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
                                                        ie.valor_huella_comparativo =
                                                            null;
                                                        ie.alcances_huella =
                                                            null;
                                                        ie.priorizacion = null;
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
                                        </div>
                                    </div>

                                    <!-- Paso 3 -->
                                    <div v-if="paso == 3">
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La empresa ha realizado un
                                                proceso de revisión y
                                                verificación interna de su
                                                huella de carbono organizacional
                                                del año base, por parte de
                                                alguien diferente a quien la
                                                calculó y reportó?
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
                                                    ie.acciones_mejora = null;
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
                                                    @input="
                                                        ie.declaracion_conformidad_tercero =
                                                            null;
                                                        ie.acciones_mejora =
                                                            null;
                                                    "
                                                />
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                ie.verificacion_interna &&
                                                ie.verificacion_tercero
                                            "
                                        >
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
                                        </div>
                                    </div>

                                    <!-- Paso 4 -->
                                    <div v-if="paso == 4">
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿En la empresa se ha planteado
                                                metas de mitigación de Gases
                                                Efecto Invernadero (GEI)?
                                            </label>
                                            <Multiselect
                                                v-model="ie.metas_mitigacion"
                                                :options="options_si_no"
                                                placeholder="Seleccione una opción"
                                                required
                                                @input="
                                                    ie.meta_reduccion = null;
                                                    ie.anio_meta = null;
                                                    ie.anio_proyeccion_meta =
                                                        null;
                                                    ie.meta_alineada = null;
                                                    ie.metodologia = null;
                                                    ie.otra_metodologia = null;
                                                    ie.seguimiento_cumplimiento =
                                                        null;
                                                "
                                            />
                                        </div>
                                        <div v-if="ie.metas_mitigacion">
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
                                        </div>

                                        <div v-if="ie.anio_meta">
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
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label class="required"
                                                            >¿Cuál de éstas
                                                            metodologías empleó
                                                            la empresa en la
                                                            formulación de la
                                                            meta?
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
                                        </div>
                                    </div>

                                    <!-- Paso 5 -->
                                    <div v-if="paso == 5">
                                        <div class="mb-3">
                                            <p><b>Pertinencia</b></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La organización para el
                                                desarrollo de sus actividades
                                                productivas y/o administrativas
                                                ha identificado las fuentes de
                                                gases de efecto invernadero?
                                            </label>
                                            <Multiselect
                                                v-model="ie.efecto_invernadero"
                                                :options="options_puntaje_1"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La organización tiene
                                                sumideros y/o reservorios en los
                                                límites de sus instalaciones?
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
                                                >¿En la organización cuentan con
                                                información mensual de consumos
                                                de todas las fuentes GEI?
                                            </label>
                                            <Multiselect
                                                v-model="ie.informacion_mensual"
                                                :options="options_puntaje_2"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La organización cuenta con un
                                                diagrama de procesos en donde se
                                                identifica el energético
                                                necesario para desarrollar cada
                                                etapa?
                                            </label>
                                            <Multiselect
                                                v-model="ie.diagrama_procesos"
                                                :options="options_puntaje_1"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿Se cuenta con las
                                                características de las áreas de
                                                sumidero (edad, especie,
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
                                                >¿La información de consumos de
                                                las fuentes GEI se encuentra
                                                centralizada?
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
                                                >¿La información de consumos de
                                                las fuentes GEI cuenta con
                                                soportes como facturas,
                                                plataforma, registros?
                                            </label>
                                            <Multiselect
                                                v-model="ie.soportes_consumos"
                                                :options="options_puntaje_1"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿La organización cuenta con más
                                                de un año de información de
                                                consumos de las fuentes GEI?
                                            </label>
                                            <Multiselect
                                                v-model="ie.informacion_anio"
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
                                                >¿La organización ha realizado
                                                estimaciones de consumos
                                                energéticos de las fuentes GEI?
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
                                                >¿Los consumos energéticos están
                                                directamente relacionados con la
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
                                                >¿En caso de tener estimaciones
                                                de consumos energéticos, se
                                                cuenta con sustento metodológico
                                                para los cálculos?
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
                                                carbono lo compartirá con las
                                                partes interesadas?
                                            </label>
                                            <Multiselect
                                                v-model="ie.compartira_reporte"
                                                :options="options_puntaje_1"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="required"
                                                >¿El reporte de huella de
                                                carbono es previsto para la toma
                                                de decisiones?
                                            </label>
                                            <Multiselect
                                                v-model="ie.toma_decisiones"
                                                :options="options_puntaje_1"
                                                placeholder="Seleccione una opción"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 text-start">
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                v-if="paso != 1"
                                                @click="
                                                    paso =
                                                        paso == 4
                                                            ? ie.huella_base ==
                                                              0
                                                                ? (paso = 2)
                                                                : 3
                                                            : paso - 1
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
                                                                style="
                                                                    border-top-left-radius: var(
                                                                        --bs-accordion-inner-border-radius
                                                                    );
                                                                    border-top-right-radius: var(
                                                                        --bs-accordion-inner-border-radius
                                                                    );
                                                                    border-top: var(
                                                                            --bs-accordion-border-width
                                                                        )
                                                                        solid
                                                                        var(
                                                                            --bs-accordion-border-color
                                                                        ) !important;
                                                                "
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
                                                                {{ sp.nombre }}
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
                                                                        del sub
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
                                                                    <label>
                                                                        Combustibles
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
                                                                        >Combustibles
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label>
                                                                        Combustibles
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label>
                                                                        Refrigerantes</label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
                                                                        >Fugas
                                                                        de CO2
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label>
                                                                        Aislante
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
                                                                    />
                                                                </div>

                                                                <h2>
                                                                    Emisiones de
                                                                    proceso
                                                                </h2>

                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                        >Combustibles
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label>
                                                                        Combustibles
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
                                                                    />
                                                                </div>

                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label>
                                                                        Refrigerantes</label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
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
                                                                    />
                                                                </div>

                                                                <h2>
                                                                    Agrícolas
                                                                </h2>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
                                                                        >Manejo
                                                                        de
                                                                        residuos
                                                                        agropecuarios
                                                                    </label>
                                                                    <Multiselect
                                                                        v-model="
                                                                            sp
                                                                                .emisiones
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
                                                                        >Uso
                                                                        fertilizantes
                                                                    </label>
                                                                    <Multiselect
                                                                        v-model="
                                                                            sp
                                                                                .emisiones
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
                                                                    />
                                                                </div>
                                                                <div
                                                                    class="mb-3"
                                                                >
                                                                    <label
                                                                        >Cal
                                                                        aplicada
                                                                    </label>
                                                                    <Multiselect
                                                                        v-model="
                                                                            sp
                                                                                .emisiones
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

                                                <div class="mt-3 text-end">
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
                                        <label>Energía eléctrica</label>
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
                                        />
                                    </div>
                                    <p>ENERGÍA IMPORTADA</p>
                                    <div class="mb-3">
                                        <label>Combustibles sólidos</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Combustibles líquidos</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Combustibles gaseosos</label>
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
                                        <label>Combustibles líquidos</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Combustibles gaseosos</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Refrigerantes</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Extintores</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Lubricantes</label>
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
                                        />
                                    </div>
                                    <p>TRANSPORTE CARGA Y PASAJEROS</p>
                                    <div class="mb-3">
                                        <label>Transporte de carga</label>
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
                                        <label
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Aislante eléctrico</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Equipos</label>
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
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Materias primas </label>
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
                                        />
                                    </div>
                                    <p>SERVICIOS</p>
                                    <div class="mb-3">
                                        <label>Manejo de residuos </label>
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
                        id="consumos-transversales"
                        role="tabpanel"
                        aria-labelledby="consumos-transversales-tab"
                    >
                        <p>En construcción</p>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="construccion-anio"
                        role="tabpanel"
                        aria-labelledby="construccion-anio-tab"
                    >
                        <form @submit.prevent="guardarDatosConsumos">
                            <div class="mb-3 table-responsive">
                                <div class="accordion" id="accordion-fuentes">
                                    <div
                                        class="accordion-item"
                                        v-for="(
                                            fuente, i, j
                                        ) in fuentes_emision"
                                        v-bind:key="i"
                                    >
                                        <h2
                                            class="accordion-header"
                                            :id="'heading-fuente-' + j"
                                        >
                                            <button
                                                class="accordion-button"
                                                :class="
                                                    j != 0 ? 'collapsed' : ''
                                                "
                                                type="button"
                                                data-bs-toggle="collapse"
                                                :data-bs-target="
                                                    '#panel-fuente' + j
                                                "
                                                aria-expanded="true"
                                                :aria-controls="
                                                    'panel-fuente' + j
                                                "
                                            >
                                                {{ i }}
                                            </button>
                                        </h2>
                                        <div
                                            :id="'panel-fuente' + j"
                                            class="accordion-collapse collapse"
                                            :class="j == 0 ? 'show' : ''"
                                            :aria-labelledby="
                                                'heading-fuente-' + j
                                            "
                                        >
                                            <div class="accordion-body">
                                                <div
                                                    class="row mb-3"
                                                    v-for="(f, i) in fuente"
                                                    v-bind:key="i"
                                                >
                                                    <div class="col-lg-4">
                                                        <p>
                                                            <b
                                                                >FUENTE DE
                                                                EMISIÓN DE
                                                                GEI</b
                                                            >
                                                        </p>
                                                        <p>
                                                            {{
                                                                f.fuente_emision_mostrar +
                                                                " - " +
                                                                f.fuentetable
                                                                    .nombre
                                                            }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <p>
                                                            <b
                                                                >UNIDAD DE
                                                                CONSUMO</b
                                                            >
                                                        </p>
                                                        <p>
                                                            {{
                                                                f.fuentetable
                                                                    .unidad_consumo
                                                            }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <p><b>CONSUMOS</b></p>
                                                        <div
                                                            class="mb-3"
                                                            v-for="(
                                                                e, i
                                                            ) in array_consumos"
                                                            v-bind:key="i"
                                                        >
                                                            <label>
                                                                {{ e }}

                                                                <i
                                                                    v-if="
                                                                        !e.includes(
                                                                            'CONSUMO'
                                                                        )
                                                                    "
                                                                    class="fas fa-question-circle"
                                                                    data-bs-toggle="popover"
                                                                    title="Título ayuda"
                                                                    data-bs-content="Texto ayuda"
                                                                ></i>
                                                            </label>

                                                            <input
                                                                v-if="
                                                                    e.includes(
                                                                        'CONSUMO'
                                                                    )
                                                                "
                                                                v-model="
                                                                    f.resultado[
                                                                        'dato_' +
                                                                            (i +
                                                                                1)
                                                                    ]
                                                                "
                                                                class="form-control"
                                                                type="number"
                                                                step="any"
                                                            />
                                                            <input
                                                                v-else
                                                                v-model="
                                                                    f.resultado[
                                                                        'incertidumbre_sistematica_adicional'
                                                                    ]
                                                                "
                                                                class="form-control"
                                                                type="number"
                                                                step="any"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div
                                    class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2"
                                >
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
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
import Electricidad from "../../models/Electricidad";
import Viaje from "../../models/Viaje";
import User from "../../models/User";

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
                unidad_id: null,
                anio_inicio: null,
                mes_inicio: null,
                usuario_creacion_id: null,
                empresa_id: null,
                sede_id: null,
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
                                Residuos_agropecuarios: [],
                                Fertilizant: [],
                                Cal: [],
                            },
                        },
                    ],
                },
            ],
            fuentes_emision: [],

            valor_option_metodologia: "",

            fecha_base: "",

            array_consumos: [],

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
            bsPopover: null,
            user: new User(),
        };
    },
    mounted() {
        // this.getInformacionEmpresa();
        this.getUserLogged();
        this.getParametros(7, "options_anio");
        this.getParametros(8, "options_mes");
        this.getParametros(12, "options_metodologia");
        this.getParametros(13, "options_unidad");
        this.getOptionsFuenteEmision();
        this.recargarFormularioEmisiones();
    },
    methods: {
        async recargarFormularioEmisiones() {
            if (!this.user.empresa_id) {
                await this.getUserLogged();
            }
            let informacionEmpresa = await InformacionEmpresa.where({
                empresa_id: this.user.empresa_id,
                sede_id: this.user.sede_id,
            }).first();
            this.ie =
                informacionEmpresa &&
                Object.keys(informacionEmpresa).length != 0
                    ? informacionEmpresa
                    : this.ie;
            console.log(this.ie);
        },
        async getUserLogged() {
            await axios
                .get("api/user")
                .then((response) => {
                    this.user = response.data;
                })
                .catch((error) => {});
        },
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

                //reemplazar por datos de usuario y empresa. se mueve a back
                await this.ie.save();

                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Información guardada exitosamente",
                    "success"
                );
                this.recargarFormularioEmisiones();
                this.paso = 1;
                $("#construccion-proceso-tab").click();

                //this.paso = 1;
                /*Object.keys(this.ie).forEach((key) => {
                    this.ie[key] = null;
                });*/
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
                    this.recargarFormularioEmisiones();
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
                        "No se pudo guardar la información, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        async guardarDatosConsumos() {
            this.$root.mostrarCargando("Guardando información");
            axios
                .post("api/guardarDatosConsumos", {
                    fuentes_emision: this.fuentes_emision,
                })
                .then((response) => {
                    Swal.close();
                    this.$root.mostrarMensaje(
                        "Éxito",
                        "Información guardada exitosamente",
                        "success"
                    );
                    setTimeout(() => {
                        this.getFuentesEmision();
                    }, 1000);
                })
                .catch((error) => {});
        },

        async getFuentesEmision() {
            //se debe enviar empresa id y sede id, por el momento se utiliza 1 y 1
            this.$root.mostrarCargando("consultado información");

            axios
                .get(
                    "api/getFuentesEmision/" +
                        this.user.empresa_id +
                        "/" +
                        this.user.sede_id
                )
                .then((response) => {
                    this.fuentes_emision = response.data;
                })
                .catch((error) => {});

            this.tablaEmisiones();

            Swal.close();
        },

        async guardarInicioConsumo() {
            this.$root.mostrarCargando("Guardando información");

            let informacion_empresa = await InformacionEmpresa.where({
                empresa_id: this.user.empresa_id,
                sede_id: this.user.sede_id,
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
            this.array_consumos = [];
            let informacion_empresa = await InformacionEmpresa.where({
                empresa_id: this.user.empresa_id,
                sede_id: this.user.sede_id,
            }).first();

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
                this.array_consumos.push(
                    "CONSUMO MES " + (i + 1) + " (" + month + " " + year + ")"
                );
            }
            this.array_consumos.push("INCERTIDUMBRE SISTEMATICA ADICIONAL");
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
                                Residuos_agropecuarios: [],
                                Fertilizante: [],
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
