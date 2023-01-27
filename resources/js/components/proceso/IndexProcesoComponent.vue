<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Ingresar datos</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs">
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
                    <li class="nav-item" role="presentation" v-if="etapa >= 2">
                        <button
                            class="nav-link"
                            id="construccion-proceso-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#construccion-proceso"
                            type="button"
                            role="tab"
                            aria-controls="construccion-proceso"
                            aria-selected="false"
                            ref="tabConstruccionProceso"
                            @click="recargarProcesos()"
                        >
                            Construcción del proceso productivo de la empresa
                        </button>
                    </li>
                    <li
                        class="nav-item"
                        role="presentation"
                        v-if="parseInt(ie.datos_proveedores) && etapa >= 3"
                    >
                        <button
                            class="nav-link"
                            id="consumos-indirectos-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#consumos-indirectos"
                            type="button"
                            role="tab"
                            aria-controls="consumos-indirectos"
                            aria-selected="false"
                            @click="recargarEmisiones()"
                        >
                            Consumos indirectos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" v-if="etapa >= 4">
                        <button
                            class="nav-link"
                            id="consumos-transversales-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#consumos-transversales"
                            type="button"
                            role="tab"
                            aria-controls="consumos-transversales"
                            aria-selected="false"
                            @click="recargarTrasversales()"
                        >
                            Consumos transversales (de apoyo) en la organización
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" v-if="etapa >= 5">
                        <button
                            class="nav-link"
                            id="inicio-consumos-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#inicio-consumos"
                            type="button"
                            role="tab"
                            aria-controls="inicio-consumos"
                            aria-selected="false"
                            @click="recargarInformacionInicio()"
                        >
                            Información inicio de consumos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" v-if="etapa >= 6">
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
                                                    "
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
                                                            :disabled="
                                                                accion_formulario ==
                                                                'ver'
                                                            "
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
                                                    :disabled="
                                                        accion_formulario ==
                                                        'ver'
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                :disabled="
                                                    accion_formulario == 'ver'
                                                "
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
                                                {{
                                                    this.paso != 5
                                                        ? "Siguiente"
                                                        : "Guardar"
                                                }}
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
                                        <br />
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button border-bottom font-weight-bold collapsed"
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
                                                <i
                                                    class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"
                                                ></i>
                                                <i
                                                    class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"
                                                ></i>
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
                                                        :disabled="
                                                            accion_procesos ==
                                                            'ver'
                                                        "
                                                    />
                                                </div>
                                                <div
                                                    style="padding-left: 30px"
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
                                                                class="accordion-button border-bottom font-weight-bold collapsed"
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
                                                                <i
                                                                    class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                                    aria-hidden="true"
                                                                ></i>
                                                                <i
                                                                    class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                                    aria-hidden="true"
                                                                ></i>
                                                            </button>
                                                        </h2>
                                                        <div
                                                            :id="
                                                                'flush-collapse' +
                                                                ip +
                                                                is
                                                            "
                                                            class="accordion-collapse collapse show"
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
                                                                        "
                                                                        required
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
                                                                        "
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
                                                                        "
                                                                    />
                                                                </div>
                                                                <div
                                                                    v-if="
                                                                        parseInt(
                                                                            ie.fuentes_moviles
                                                                        )
                                                                    "
                                                                >
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
                                                                            "
                                                                        />
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    v-if="
                                                                        parseInt(
                                                                            ie.actividad_agricola
                                                                        )
                                                                    "
                                                                >
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
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
                                                                            :disabled="
                                                                                accion_procesos ==
                                                                                'ver'
                                                                            "
                                                                        />
                                                                    </div>
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
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
                                                                        "
                                                                        @click="
                                                                            accion_procesos ==
                                                                            'ver'
                                                                                ? ''
                                                                                : is >
                                                                                  0
                                                                                ? procesos[
                                                                                      ip
                                                                                  ][
                                                                                      'subprocesos'
                                                                                  ].splice(
                                                                                      is,
                                                                                      1
                                                                                  )
                                                                                : ''
                                                                        "
                                                                    >
                                                                        Eliminar
                                                                        subproceso
                                                                    </button>

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-success"
                                                                        :disabled="
                                                                            accion_procesos ==
                                                                            'ver'
                                                                        "
                                                                        @click="
                                                                            accion_procesos ==
                                                                            'ver'
                                                                                ? ''
                                                                                : procesos[
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
                                                        :disabled="
                                                            accion_procesos ==
                                                            'ver'
                                                        "
                                                        @click="
                                                            accion_procesos ==
                                                            'ver'
                                                                ? ''
                                                                : ip > 0
                                                                ? procesos.splice(
                                                                      ip,
                                                                      1
                                                                  )
                                                                : ''
                                                        "
                                                    >
                                                        Eliminar proceso
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="btn btn-success"
                                                        :disabled="
                                                            accion_procesos ==
                                                            'ver'
                                                        "
                                                        @click="
                                                            accion_procesos ==
                                                            'ver'
                                                                ? ''
                                                                : procesos.splice(
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
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="accion_procesos == 'ver'"
                                >
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
                                    :disabled="accion_inicio == 'ver'"
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
                                    :disabled="accion_inicio == 'ver'"
                                />
                            </div>
                            <div class="mb-3">
                                <label>Unidades producidas </label>
                                <label style="color: red"
                                    >(Valor total para todo el periodo)</label
                                >
                                <input
                                    v-model="ie.unidades_producidas"
                                    class="form-control"
                                    type="text"
                                    :disabled="accion_inicio == 'ver'"
                                />
                            </div>
                            <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="accion_inicio == 'ver'"
                                >
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label>Materias primas</label>
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
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
                                        />
                                    </div>
                                    <p>SERVICIOS</p>
                                    <div class="mb-3">
                                        <label>Manejo de residuos</label>
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
                                            :disabled="
                                                accion_emisiones == 'ver'
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
                                    <div class="mb-3">
                                        <label>Producto</label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.usos
                                                    .Producto
                                            "
                                            :options="options_sf6"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
                                        />
                                    </div>
                                    <p>FIN DE VIDA</p>
                                    <div class="mb-3">
                                        <label>Producto</label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.fines
                                                    .Producto
                                            "
                                            :options="options_sf6"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
                                        />
                                    </div>
                                    <p>ACTIVOS ARRENDADOS</p>
                                    <div class="mb-3">
                                        <label>Activo</label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.activos
                                                    .Activo
                                            "
                                            :options="options_sf6"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
                                        />
                                    </div>
                                    <p>INVERSIONES</p>
                                    <div class="mb-3">
                                        <label>Activo</label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.inversiones
                                                    .Inversion
                                            "
                                            :options="options_sf6"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
                                        />
                                    </div>
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
                                    <div class="mb-3">
                                        <label>Otros</label>
                                        <Multiselect
                                            v-model="
                                                emisiones_indirectas.otros.Otro
                                            "
                                            :options="options_sf6"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            :disabled="
                                                accion_emisiones == 'ver'
                                            "
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="accion_emisiones == 'ver'"
                                >
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
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="guardarTrasversales">
                                    <div class="mb-3">
                                        <label>Consumos transversales</label>
                                        <Multiselect
                                            v-model="
                                                trasversales.trasversales
                                                    .Trasversal
                                            "
                                            :options="options_trasversal"
                                            mode="tags"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Selección múltiple"
                                            :searchable="true"
                                            :disabled="
                                                accion_trasversales == 'ver'
                                            "
                                        />
                                    </div>
                                    <div
                                        class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2"
                                    >
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            :disabled="
                                                accion_trasversales == 'ver'
                                            "
                                        >
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                                class="accordion-button border-bottom font-weight-bold collapsed"
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
                                                <i
                                                    class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"
                                                ></i>
                                                <i
                                                    class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"
                                                ></i>
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
import Trasversal from "../../models/Trasversal";
import Sf6 from "../../models/Sf6";

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
                unidades_producidas: null,
                anio_inicio: null,
                mes_inicio: null,
                usuario_creacion_id: null,
                empresa_id: null,
                sede_id: null,
            }),

            etapa: 1,
            paso: 1,
            emisiones_indirectas: {
                energias: {
                    Energia_electrica: [],
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
                    Lubricante: [],
                    Transporte: [],
                },
                productos: {
                    Refrigerante: [],
                    Extintor: [],
                    Lubricante: [],
                    Aislamiento: [],
                    Equipo: [],
                    Materia_prima: [],
                    Residuo: [],
                },
                usos: {
                    Producto: [],
                },
                fines: {
                    Producto: [],
                },
                activos: {
                    Activo: [],
                },
                inversiones: {
                    Inversion: [],
                },
                otros: {
                    Otro: [],
                },
            },
            trasversales: {
                trasversales: {
                    Trasversal: [],
                },
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
            options_trasversal: [],
            options_sf6: [],
            options_equipo_consumo: [],
            options_metodologia: [],
            options_anio: [],
            options_mes: [],
            required: "Este campo es requerido",
            bsPopover: null,
            accion_formulario: "crear",
            accion_procesos: "crear",
            accion_emisiones: "crear",
            accion_inicio: "crear",
            accion_trasversales: "crear",
            informacion_empresa_existe: true,
            user: new User(),
        };
    },
    mounted() {
        this.getUserLogged();
        this.getParametros(7, "options_anio");
        this.getParametros(8, "options_mes");
        this.getParametros(12, "options_metodologia");
        this.getOptionsFuenteEmision();
        this.recargarFormularioEmisiones();
        this.tabActiva();
    },
    methods: {
        tabActiva() {
            setTimeout(() => {
                console.log("entras");
                switch (this.etapa) {
                    case 2:
                        $("#construccion-proceso-tab").click();
                        break;
                    case 3:
                        $("#consumos-indirectos-tab").click();
                        break;
                    case 4:
                        $("#consumos-transversales-tab").click();
                        break;
                    case 5:
                        $("#inicio-consumos-tab").click();
                        break;
                    case 6:
                        $("#construccion-anio-tab").click();
                        break;
                    default:
                        break;
                }
            }, 5000);
        },
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

            if (Object.keys(informacionEmpresa).length != 0) {
                this.accion_formulario = "ver";
                this.etapa = 2;
                this.recargarProcesos();
            }
        },
        async recargarProcesos() {
            axios
                .post("/api/recargarProcesos", {
                    empresa_id: this.user.empresa_id,
                    sede_id: this.user.sede_id,
                })
                .then((response) => {
                    if (response.data.length != 0) {
                        this.procesos = response.data;
                        this.accion_procesos = "ver";

                        if (this.ie.datos_proveedores == 1) {
                            this.etapa = 3;
                            this.recargarEmisiones();
                        } else {
                            this.etapa = 4;
                            this.recargarTrasversales();
                        }
                    }
                })
                .catch((error) => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de los procesos, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        async recargarEmisiones() {
            axios
                .post("/api/recargarEmisiones", {
                    empresa_id: this.user.empresa_id,
                    sede_id: this.user.sede_id,
                })
                .then((response) => {
                    if (Object.keys(response.data).length != 0) {
                        this.emisiones_indirectas = response.data;
                        this.accion_emisiones = "ver";
                        this.etapa = 4;
                        this.recargarTrasversales();
                    }
                })
                .catch((error) => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de los procesos, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        async recargarTrasversales() {
            axios
                .post("/api/recargarTrasversales", {
                    empresa_id: this.user.empresa_id,
                    sede_id: this.user.sede_id,
                })
                .then((response) => {
                    if (Object.keys(response.data).length != 0) {
                        this.trasversales = response.data;
                        this.accion_trasversales = "ver";
                        this.etapa = 5;
                        this.recargarInformacionInicio();
                    }
                })
                .catch((error) => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de los procesos, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        async recargarInformacionInicio() {
            let informacionEmpresa = await InformacionEmpresa.where({
                empresa_id: this.user.empresa_id,
                sede_id: this.user.sede_id,
            }).first();

            if (informacionEmpresa.anio_inicio != null) {
                this.accion_inicio = "ver";
                this.etapa = 6;
            }
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

            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },
        async getOptionsFuenteEmision() {
            this.$root.mostrarCargando("Cargando información");
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

            this.options_trasversal = await Trasversal.get();
            this.options_sf6 = await Sf6.get();

            Swal.close();
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
                if (this.accion_formulario == "ver" && this.paso == 5) {
                    this.paso = 5;
                } else {
                    this.paso++;
                }
            }

            if (this.paso == 6 && this.accion_formulario == "crear") {
                this.$root.mostrarCargando("Guardando información");

                await this.ie.save();

                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Información guardada exitosamente",
                    "success"
                );
                this.recargarFormularioEmisiones();
                setTimeout(() => {
                    $("#construccion-proceso-tab").click();
                }, 200);
                this.paso = 1;
            }
        },

        async guardarProcesos() {
            if (this.accion_procesos != "ver") {
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
                        this.recargarProcesos();
                        setTimeout(() => {
                            if (this.ie.datos_proveedores == 1) {
                                $("#consumos-indirectos-tab").click();
                            } else {
                                $("#consumos-transversales-tab").click();
                            }
                        }, 500);
                    })
                    .catch((error) => {
                        Swal.fire(
                            "Error",
                            "No se pudo guardar la información, por favor inténtelo nuevamente",
                            "error"
                        );
                    });
            }
        },

        guardarEmisionesIndirectas() {
            if (this.accion_emisiones != "ver") {
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
                        this.recargarEmisiones();

                        setTimeout(() => {
                            $("#consumos-transversales-tab").click();
                        }, 200);
                    })
                    .catch((error) => {
                        Swal.fire(
                            "Error",
                            "No se pudo obtener la información de la persona, por favor inténtelo nuevamente",
                            "error"
                        );
                    });
            }
        },

        async guardarTrasversales() {
            if (this.accion_trasversales != "ver") {
                this.$root.mostrarCargando("Guardando información");
                axios
                    .post("/api/guardarTrasversales", {
                        trasversales: this.trasversales,
                    })
                    .then((response) => {
                        Swal.close();
                        this.$root.mostrarMensaje(
                            "Éxito",
                            "Información guardada exitosamente",
                            "success"
                        );
                        this.recargarTrasversales();
                        setTimeout(() => {
                            $("#inicio-consumos-tab").click();
                        }, 200);
                    })
                    .catch((error) => {
                        Swal.fire(
                            "Error",
                            "No se pudo guardar la información, por favor inténtelo nuevamente",
                            "error"
                        );
                    });
            }
        },

        async guardarInicioConsumo() {
            if (this.accion_inicio != "ver") {
                this.$root.mostrarCargando("Guardando información");

                let informacion_empresa = await InformacionEmpresa.where({
                    empresa_id: this.user.empresa_id,
                    sede_id: this.user.sede_id,
                }).first();

                informacion_empresa.unidades_producidas =
                    this.ie.unidades_producidas;
                informacion_empresa.anio_inicio = this.ie.anio_inicio;
                informacion_empresa.mes_inicio = this.ie.mes_inicio;
                await informacion_empresa.save();

                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Información guardada exitosamente",
                    "success"
                );
                this.recargarInformacionInicio();
                setTimeout(() => {
                    $("#construccion-anio-tab").click();
                }, 200);
            }
        },

        async guardarDatosConsumos() {
            // this.$root.mostrarCargando("Guardando información");
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
