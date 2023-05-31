<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>Ingresar datos</h4>
                <label>
                    Para realizar el cálculo de la huella de carbono de la sede
                    de la empresa, a continuación deberá ingresar información
                    técnica respecto a los procesos productivos, consumos de
                    combustibles, energía, etc, equipos, fuente de emisión de
                    gases efecto invernadero, entre otras, asociadas a un
                    periodo de tiempo específico (12 meses, donde debe indicar
                    mes de inicio y año). Por favor tenga a la mano la
                    información, le invitamos a consultar el listado de
                    preguntas y de datos requeridos
                    <a
                        href="pdf/guia_ingreso_datos.pdf"
                        target="_blank"
                        style="color: #208943"
                        ><b><u>AQUÍ.</u></b>
                    </a>
                </label>
            </div>
        </div>
        <div class="col-lg-12" v-if="user.rol_id == 2">
            <div v-if="huellas.length != 0">
                <table
                    class="table table-sm align-items-center mb-3 w-100"
                    style="font-size: 0.75rem"
                >
                    <thead>
                        <tr>
                            <th>Huella</th>
                            <th>Periodo</th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(h, i) in huellas" v-bind:key="i">
                            <td>
                                {{
                                    h.nombre == null ? "Sin definir" : h.nombre
                                }}
                            </td>
                            <td>
                                {{
                                    h.anio_inicio == null
                                        ? "Sin definir"
                                        : h.periodo
                                }}
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="s btn btn-warning btn-sm"
                                    :ref="
                                        h.estado == 1
                                            ? 'huellaActiva'
                                            : 'huellaInactiva'
                                    "
                                    @click="
                                        ie_id = h.id;
                                        recargarFormularioEmisiones();
                                        tabActiva();
                                    "
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <button
                    v-if="huella_existe && parseInt(permiso_huella)"
                    type="button"
                    class="btn btn-success"
                    @click="nuevaHuella()"
                >
                    Generar nueva huella
                </button>
                <button v-else type="button" class="btn btn-warning" disabled>
                    Sin autorización para generar nueva huella
                </button>
            </div>
        </div>
        <form
            @submit.prevent="
                recargarFormularioEmisiones();
                tabActiva();
            "
            v-if="user.rol_id == 3"
        >
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label class="required">Empresa</label>
                    <Multiselect
                        valueProp="id"
                        label="nombre"
                        v-model="empresa_id"
                        :options="options_empresa"
                        placeholder="Seleccione una opción"
                        @input="getOptionsSede()"
                        required
                    />
                </div>
                <div class="col-lg-3">
                    <label class="required">Sede</label>
                    <Multiselect
                        valueProp="id"
                        label="nombre"
                        v-model="sede_id"
                        :options="options_sede"
                        placeholder="Seleccione una opción"
                        @input="getOptionsPeriodo()"
                        required
                    />
                </div>
                <div class="col-lg-3">
                    <label class="required">Periodo</label>
                    <Multiselect
                        v-model="ie_id"
                        :options="options_ie"
                        placeholder="Seleccione una opción"
                        required
                    />
                </div>
                <div class="col-lg-3">
                    <label>&nbsp</label>
                    <br />
                    <button type="submit" class="btn btn-success">
                        Consultar
                    </button>
                </div>
            </div>
        </form>

        <hr />
        <br />

        <h4>
            {{
                Object.keys(ie).length === 0
                    ? ""
                    : ie.nombre == null
                    ? "Sin definir"
                    : ie.nombre
            }}
        </h4>
        <ul
            class="nav nav-pills nav-fill mb-3"
            id="tabs-ingresar-datos"
            v-if="mostrar_formulario"
        >
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active badge rounded-pill"
                    id="formulario-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#formulario"
                    type="button"
                    role="tab"
                    aria-controls="formulario"
                    aria-selected="true"
                >
                    1 <span>Formulario</span>
                </button>
            </li>
            <li class="nav-item" role="presentation" v-if="etapa >= 2">
                <button
                    class="nav-link badge rounded-pill"
                    id="seleccion-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#seleccion"
                    type="button"
                    role="tab"
                    aria-controls="seleccion"
                    aria-selected="true"
                    @click="recargarFuentesEmision()"
                >
                    2 <span>Fuentes de emisión</span>
                </button>
            </li>
            <li class="nav-item" role="presentation" v-if="etapa >= 3">
                <button
                    class="nav-link badge rounded-pill"
                    id="construccion-proceso-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#construccion-proceso"
                    type="button"
                    role="tab"
                    aria-controls="construccion-proceso"
                    aria-selected="false"
                    @click="recargarProcesos()"
                >
                    3
                    <span
                        >Construcción del proceso productivo de la empresa</span
                    >
                </button>
            </li>
            <li class="nav-item" role="presentation" v-if="etapa >= 4">
                <button
                    class="nav-link badge rounded-pill"
                    id="inicio-consumos-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#inicio-consumos"
                    type="button"
                    role="tab"
                    aria-controls="inicio-consumos"
                    aria-selected="false"
                    @click="recargarInformacionInicio()"
                >
                    4 <span>Información inicio de consumos</span>
                </button>
            </li>
            <li class="nav-item" role="presentation" v-if="etapa >= 5">
                <button
                    class="nav-link badge rounded-pill"
                    id="construccion-anio-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#construccion-anio"
                    type="button"
                    role="tab"
                    aria-controls="construccion-anio"
                    aria-selected="false"
                    @click="getFuentesEmision()"
                >
                    5 <span>Construcción de año base de emisiones de GEI</span>
                </button>
            </li>
        </ul>
        <div
            class="tab-content"
            id="pills-tabContent"
            v-if="mostrar_formulario"
        >
            <div
                class="tab-pane fade show active"
                id="formulario"
                role="tabpanel"
                aria-labelledby="formulario-tab"
            >
                <br />
                <form @submit.prevent="guardarInformacion">
                    <!-- Paso 1 -->
                    <div v-if="paso == 1">
                        <div class="mb-3">
                            <label class="required">Nombre de la huella</label>
                            <input
                                v-model="ie.nombre"
                                class="form-control"
                                type="text"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La empresa ha calculado su huella de carbono
                                organizacional para un año base?
                            </label>
                            <Multiselect
                                v-model="ie.huella_base"
                                :options="options_si_no"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                                @input="
                                    ie.valor_huella_base = null;
                                    ie.huella_comparativo = null;
                                    ie.valor_huella_comparativo = null;
                                    ie.alcances_huella = null;
                                    ie.priorizacion = null;
                                    ie.indicador = null;
                                "
                            />
                        </div>
                        <div v-if="parseInt(ie.huella_base)">
                            <div class="mb-3">
                                <label class="required"
                                    >¿Cuál es el valor de la huella de carbono
                                    de la empresa en su año base?
                                </label>
                                <input
                                    v-model="ie.valor_huella_base"
                                    class="form-control"
                                    type="number"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿La empresa ha calculado su huella de
                                    carbono organizacional para un año
                                    comparativo?
                                </label>
                                <Multiselect
                                    v-model="ie.huella_comparativo"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    :disabled="!editar_formulario"
                                    required
                                    @input="
                                        ie.valor_huella_comparativo = null;
                                        ie.alcances_huella = null;
                                        ie.priorizacion = null;
                                        ie.indicador = null;
                                    "
                                />
                            </div>
                        </div>
                        <div
                            v-if="
                                parseInt(ie.huella_base) &&
                                parseInt(ie.huella_comparativo)
                            "
                        >
                            <div class="mb-3">
                                <label class="required"
                                    >¿Cuál es el valor de la huella de carbono
                                    de la empresa en su año comparativo?
                                </label>
                                <input
                                    v-model="ie.valor_huella_comparativo"
                                    class="form-control"
                                    type="number"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿Qué alcances - categorías cubre el cálculo
                                    de la huella de carbono organizacional?
                                </label>
                                <textarea
                                    v-model="ie.alcances_huella"
                                    class="form-control"
                                    :disabled="!editar_formulario"
                                    required
                                ></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿Se realizó una priorización de fuentes de
                                    emisión para definir otras emisiones
                                    indirectas?
                                </label>
                                <Multiselect
                                    v-model="ie.priorizacion"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿La empresa ha definido algún indicador de
                                    intensidad o correlación de sus emisiones
                                    con su producción o servicios prestados?
                                </label>
                                <Multiselect
                                    v-model="ie.indicador"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Paso 2 -->
                    <div v-if="paso == 2">
                        <div class="mb-3">
                            <label class="required"
                                >¿La empresa ha realizado un proceso de revisión
                                y verificación interna de su huella de carbono
                                organizacional del año base, por parte de
                                alguien diferente a quien la calculó y reportó?
                            </label>
                            <Multiselect
                                v-model="ie.verificacion_interna"
                                :options="options_si_no"
                                placeholder="Seleccione una opción"
                                required
                                :disabled="!editar_formulario"
                                @input="
                                    ie.optimizacion_procesos = null;
                                    ie.verificacion_tercero = null;
                                    ie.declaracion_conformidad_tercero = null;
                                    ie.acciones_mejora = null;
                                "
                            />
                        </div>
                        <div v-if="parseInt(ie.verificacion_interna)">
                            <div class="mb-3">
                                <label class="required"
                                    >¿Se optimizaron los procesos de cálculo y
                                    reporte como producto de esta
                                    preverificación?
                                </label>
                                <Multiselect
                                    v-model="ie.optimizacion_procesos"
                                    :disabled="!editar_formulario"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿Un tercero ha realizado el proceso de
                                    verificación de la huella de carbono
                                    organizacional del año base?
                                </label>
                                <Multiselect
                                    v-model="ie.verificacion_tercero"
                                    :disabled="!editar_formulario"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    required
                                    @input="
                                        ie.declaracion_conformidad_tercero =
                                            null;
                                        ie.acciones_mejora = null;
                                    "
                                />
                            </div>
                        </div>
                        <div
                            v-if="
                                parseInt(ie.verificacion_interna) &&
                                parseInt(ie.verificacion_tercero)
                            "
                        >
                            <div class="mb-3">
                                <label class="required"
                                    >¿Se obtuvo la declaración de conformidad
                                    asociada en el proceso de verificación por
                                    parte del tercero?
                                </label>
                                <Multiselect
                                    v-model="ie.declaracion_conformidad_tercero"
                                    :disabled="!editar_formulario"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿Se identificaron las acciones de mejora
                                    para poder cumplir con todos los requisitos
                                    del proceso?
                                </label>
                                <Multiselect
                                    v-model="ie.acciones_mejora"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3 -->
                    <div v-if="paso == 3">
                        <div class="mb-3">
                            <label class="required"
                                >¿En la empresa se han planteado metas de
                                mitigación de Gases Efecto Invernadero (GEI)?
                            </label>
                            <Multiselect
                                v-model="ie.metas_mitigacion"
                                :options="options_si_no"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                                @input="
                                    ie.meta_reduccion = null;
                                    ie.anio_meta = null;
                                    ie.anio_proyeccion_meta = null;
                                    ie.meta_alineada = null;
                                    ie.metodologia = null;
                                    ie.otra_metodologia = null;
                                    ie.seguimiento_cumplimiento = null;
                                "
                            />
                        </div>
                        <div v-if="parseInt(ie.metas_mitigacion)">
                            <div class="mb-3">
                                <label class="required"
                                    >¿Cuál es la meta de reducción de emisiones
                                    de GEI de la empresa? (t CO2eq / año)
                                </label>
                                <input
                                    v-model="ie.meta_reduccion"
                                    class="form-control"
                                    type="number"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿Conoce el año de proyección para esa meta?
                                </label>
                                <Multiselect
                                    v-model="ie.anio_meta"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    :disabled="!editar_formulario"
                                    required
                                    @input="
                                        ie.anio_proyeccion_meta = null;
                                        ie.meta_alineada = null;
                                        ie.metodologia = null;
                                        ie.otra_metodologia = null;
                                        ie.seguimiento_cumplimiento = null;
                                    "
                                />
                            </div>
                        </div>

                        <div v-if="parseInt(ie.anio_meta)">
                            <div class="mb-3">
                                <label class="required"
                                    >¿A que año está proyectada esta meta?
                                </label>
                                <input
                                    v-model="ie.anio_proyeccion_meta"
                                    class="form-control"
                                    type="number"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿La meta está alineada con los compromisos
                                    nacionales (NDC), con las metas de reducción
                                    del acuerdo de París y/o con otro compromiso
                                    sectorial o de otro tipo?
                                </label>
                                <Multiselect
                                    v-model="ie.meta_alineada"
                                    :options="options_si_no"
                                    placeholder="Seleccione una opción"
                                    :disabled="!editar_formulario"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="required"
                                            >¿Cuál de éstas metodologías empleó
                                            la empresa en la formulación de la
                                            meta?
                                        </label>
                                        <Multiselect
                                            v-model="ie.metodologia"
                                            :options="options_metodologia"
                                            valueProp="id"
                                            label="nombre"
                                            placeholder="Seleccione una opción"
                                            required
                                            :disabled="!editar_formulario"
                                            @input="changeMetodologia()"
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
                                            v-model="ie.otra_metodologia"
                                            type="text"
                                            class="form-control"
                                            :required="valor_option_metodologia"
                                            :disabled="
                                                !valor_option_metodologia
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="required"
                                    >¿Se ha realizado algún seguimiento al
                                    cumplimiento de la meta o se cuenta con un
                                    plan de monitoreo asociado?
                                </label>
                                <Multiselect
                                    v-model="ie.seguimiento_cumplimiento"
                                    :disabled="!editar_formulario"
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
                            <p><b>Pertinencia</b></p>
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿Para el desarrollo de sus actividades
                                productivas y/o administrativas, la organización
                                ha identificado las fuentes de gases de efecto
                                invernadero?
                            </label>
                            <Multiselect
                                v-model="ie.efecto_invernadero"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La organización tiene sumideros y/o
                                reservorios de carbono en los límites de sus
                                instalaciones?
                            </label>
                            <Multiselect
                                v-model="ie.sumideros"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <p><b>Integralidad</b></p>
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La organización cuenta con información mensual
                                de consumos de todas las fuentes GEI?
                            </label>
                            <Multiselect
                                v-model="ie.informacion_mensual"
                                :options="options_puntaje_2"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La organización cuenta con un diagrama de
                                procesos en donde se identifica el energético
                                necesario para desarrollar cada etapa?
                            </label>
                            <Multiselect
                                v-model="ie.diagrama_procesos"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿Se cuenta con las características de las áreas
                                de sumidero (edad, especie, hectáreas)?
                            </label>
                            <Multiselect
                                v-model="ie.areas_sumideros"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <p><b>Coherencia</b></p>
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La información de consumos de las fuentes GEI
                                se encuentra centralizada?
                            </label>
                            <Multiselect
                                v-model="ie.informacion_centralizada"
                                :options="options_puntaje_1"
                                :disabled="!editar_formulario"
                                placeholder="Seleccione una opción"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La información de consumos de las fuentes GEI
                                cuenta con soportes como facturas, plataforma,
                                registros?
                            </label>
                            <Multiselect
                                v-model="ie.soportes_consumos"
                                :options="options_puntaje_2"
                                :disabled="!editar_formulario"
                                placeholder="Seleccione una opción"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La organización cuenta con más de un año de
                                información de consumos de las fuentes GEI?
                            </label>
                            <Multiselect
                                v-model="ie.informacion_anio"
                                :options="options_puntaje_1"
                                :disabled="!editar_formulario"
                                placeholder="Seleccione una opción"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <p><b>Exactitud</b></p>
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿La organización ha realizado estimaciones de
                                consumos energéticos de las fuentes GEI?
                            </label>
                            <Multiselect
                                v-model="ie.estimaciones_consumos"
                                :options="options_puntaje_1"
                                :disabled="!editar_formulario"
                                placeholder="Seleccione una opción"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿Los consumos energéticos están directamente
                                relacionados con la producción?
                            </label>
                            <Multiselect
                                v-model="ie.consumos_energeticos"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿En caso de tener estimaciones de consumos
                                energéticos, se cuenta con sustento metodológico
                                para los cálculos?
                            </label>
                            <Multiselect
                                v-model="ie.sustento_metodologico"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <p><b>Transparencia</b></p>
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿El reporte de huella de carbono lo compartirá
                                con las partes interesadas?
                            </label>
                            <Multiselect
                                v-model="ie.compartira_reporte"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="required"
                                >¿El reporte de huella de carbono es utilizado
                                para la toma de decisiones?
                            </label>
                            <Multiselect
                                v-model="ie.toma_decisiones"
                                :options="options_puntaje_1"
                                placeholder="Seleccione una opción"
                                :disabled="!editar_formulario"
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
                                        paso == 3
                                            ? ie.huella_base == 0
                                                ? (paso = 1)
                                                : 2
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
                                :disabled="paso == 4 && !editar_formulario"
                            >
                                {{ this.paso != 4 ? "Siguiente" : "Guardar" }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div
                v-if="etapa >= 2"
                class="tab-pane fade"
                id="seleccion"
                role="tabpanel"
                aria-labelledby="seleccion-tab"
            >
                <br />
                <form @submit.prevent="guardarFuentesEmision()">
                    <div class="mb-3 accordion" id="accordion-categorias">
                        <div
                            class="accordion-item"
                            v-for="(value, key, index) in fuentes"
                            v-bind:key="key"
                        >
                            <p
                                style="font-size: 14px"
                                class="accordion-header"
                                :id="'heading-c-' + index"
                            >
                                <button
                                    class="accordion-button border-bottom font-weight-bold collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    :data-bs-target="'#panel-c-' + index"
                                >
                                    {{ ac[key] }}
                                    <i
                                        class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"
                                    ></i>
                                    <i
                                        class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"
                                    ></i>
                                </button>
                            </p>
                            <div
                                :id="'panel-c-' + index"
                                class="accordion-collapse collapse"
                            >
                                <div class="accordion-body">
                                    <div
                                        class="accordion-item"
                                        v-for="(val, k, i) in value"
                                        v-bind:key="k"
                                    >
                                        <p
                                            v-if="!k.includes('biogenico')"
                                            style="font-size: 13px"
                                            class="accordion-header"
                                            :id="'heading-sc-' + index + i"
                                        >
                                            <button
                                                class="accordion-button border-bottom font-weight-bold collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                :data-bs-target="
                                                    '#panel-sc-' + index + i
                                                "
                                            >
                                                {{ asc[k] }}
                                                <i
                                                    class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"
                                                ></i>
                                                <i
                                                    class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"
                                                ></i>
                                            </button>
                                        </p>
                                        <div
                                            :id="'panel-sc-' + index + i"
                                            class="accordion-collapse collapse"
                                        >
                                            <div class="accordion-body">
                                                <div
                                                    v-if="
                                                        k == 'fuentes_moviles'
                                                    "
                                                >
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            combustibles
                                                            líquidos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_liquido
                                                            "
                                                            :options="
                                                                options_combustible_liquido
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            @input="
                                                                agregarFuenteBiogenico(
                                                                    key,
                                                                    k,
                                                                    val
                                                                )
                                                            "
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>
                                                            Consumo de
                                                            combustibles
                                                            gaseosos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_gaseoso
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>
                                                            Consumo de
                                                            refrigerantes y
                                                            espumantes
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Refrigerante
                                                            "
                                                            :options="
                                                                options_refrigerante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Uso de
                                                            extintores</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Extintor
                                                            "
                                                            :options="
                                                                options_extintor
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            lubricantes
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Lubricante
                                                            "
                                                            :options="
                                                                options_lubricante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="k == 'fuentes_fijas'"
                                                >
                                                    <div class="mb-3">
                                                        <label>
                                                            Consumo de
                                                            combustibles
                                                            sólidos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_solido
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            combustibles
                                                            líquidos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_liquido
                                                            "
                                                            :options="
                                                                options_combustible_liquido
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            @input="
                                                                agregarFuenteBiogenico(
                                                                    key,
                                                                    k,
                                                                    val
                                                                )
                                                            "
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>
                                                            Consumo de
                                                            combustibles
                                                            gaseosos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_gaseoso
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>
                                                            Consumo de
                                                            refrigerantes y
                                                            espumantes</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Refrigerante
                                                            "
                                                            :options="
                                                                options_refrigerante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Uso de
                                                            extintores</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Extintor
                                                            "
                                                            :options="
                                                                options_extintor
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            lubricantes</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Lubricante
                                                            "
                                                            :options="
                                                                options_lubricante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Fugas de CO2 en
                                                            proceso</label
                                                        >
                                                        <Multiselect
                                                            v-model="val.Fuga"
                                                            :options="
                                                                options_fuga
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>
                                                            Consumo de aislante
                                                            eléctrico
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Aislamiento
                                                            "
                                                            :options="
                                                                options_aislamiento
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'emisiones'">
                                                    <div class="mb-3">
                                                        <label
                                                            >Uso de embalses o
                                                            represamientos de
                                                            agua
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Embalse
                                                            "
                                                            :options="
                                                                options_embalse
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Procesos de
                                                            minería</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Mineria
                                                            "
                                                            :options="
                                                                options_mineria
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Procesos
                                                            industriales</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Industrial
                                                            "
                                                            :options="
                                                                options_industrial
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Procesos agricolas
                                                            (ganadería -
                                                            fermentación
                                                            entérica)
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Fermentacion
                                                            "
                                                            :options="
                                                                options_fermentacion
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Procesos agrícolas
                                                            (manejo de
                                                            estiércol)
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Estiercol
                                                            "
                                                            :options="
                                                                options_estiercol
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Proceso agrícolas
                                                            (manejo de residuos
                                                            agropecuarios)
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Residuo_agropecuario
                                                            "
                                                            :options="
                                                                options_residuo_agropecuario
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Procesos agrícolas
                                                            (uso de
                                                            fertilizantes)
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Fertilizante
                                                            "
                                                            :options="
                                                                options_fertilizante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Procesos con cal
                                                        </label>
                                                        <Multiselect
                                                            v-model="val.Cal"
                                                            :options="
                                                                options_cal
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Procesos de gestión
                                                            de residuos
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Residuo_organizacional
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="
                                                        k ==
                                                        'electricidad_importada'
                                                    "
                                                >
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de energía
                                                            eléctrica</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Energia_electrica
                                                            "
                                                            :options="
                                                                options_electricidad
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="
                                                        k == 'energia_importada'
                                                    "
                                                >
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            combustibles sólidos
                                                        </label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_solido
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            combustibles
                                                            líquidos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_liquido
                                                            "
                                                            :options="
                                                                options_combustible_liquido
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            @input="
                                                                agregarFuenteBiogenico(
                                                                    key,
                                                                    k,
                                                                    val
                                                                )
                                                            "
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            combustibles
                                                            gaseosos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_gaseoso
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="
                                                        k ==
                                                        'transportes_fuentes_moviles'
                                                    "
                                                >
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            combustibles
                                                            líquidos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_liquido
                                                            "
                                                            :options="
                                                                options_combustible_liquido
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            @input="
                                                                agregarFuenteBiogenico(
                                                                    key,
                                                                    k,
                                                                    val
                                                                )
                                                            "
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            combustibles
                                                            gaseosos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Combustible_gaseoso
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            refrigerantes y
                                                            espumantes</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Refrigerante
                                                            "
                                                            :options="
                                                                options_refrigerante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Uso de
                                                            extintores</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Extintor
                                                            "
                                                            :options="
                                                                options_extintor
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            lubricantes</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Lubricante
                                                            "
                                                            :options="
                                                                options_lubricante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="
                                                        k ==
                                                        'transportes_carga_pasajeros'
                                                    "
                                                >
                                                    <div class="mb-3">
                                                        <label
                                                            >Transporte de
                                                            carga</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Transporte_carga
                                                            "
                                                            :options="
                                                                options_carga
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Transporte de
                                                            pasajeros</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Transporte_pasajeros
                                                            "
                                                            :options="
                                                                options_pasajero
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Viajes
                                                            aéreos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Transporte_aereo
                                                            "
                                                            :options="
                                                                options_aereo
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="
                                                        k == 'bienes_productos'
                                                    "
                                                >
                                                    <div class="mb-3">
                                                        <label
                                                            >Uso de
                                                            refrigerantes y
                                                            espumantes (Fuentes
                                                            fijas)</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Refrigerante
                                                            "
                                                            :options="
                                                                options_refrigerante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Uso de extintores
                                                            (Fuentes
                                                            fijas)</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Extintor
                                                            "
                                                            :options="
                                                                options_extintor
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de
                                                            lubricantes (Fuentes
                                                            móviles)</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Lubricante
                                                            "
                                                            :options="
                                                                options_lubricante
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumo de aislante
                                                            eléctrico</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Aislamiento
                                                            "
                                                            :options="
                                                                options_aislamiento
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Productos</label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Producto
                                                            "
                                                            :options="
                                                                options_producto
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Equipos</label>
                                                        <Multiselect
                                                            v-model="val.Equipo"
                                                            :options="
                                                                options_equipo
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Materias
                                                            primas</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Materia_prima
                                                            "
                                                            :options="
                                                                options_materia_prima
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'servicios'">
                                                    <div class="mb-3">
                                                        <label>Servicios</label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Servicio
                                                            "
                                                            :options="
                                                                options_servicio
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            >Gestion de
                                                            residuos</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Residuo_organizacional
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
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'usos'">
                                                    <div class="mb-3">
                                                        <label
                                                            >Producto de la
                                                            organización</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Producto
                                                            "
                                                            :options="
                                                                options_uso
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'fines'">
                                                    <div class="mb-3">
                                                        <label
                                                            >Producto de la
                                                            organización</label
                                                        >
                                                        <Multiselect
                                                            v-model="val.Fin"
                                                            :options="
                                                                options_destino
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'activos'">
                                                    <div class="mb-3">
                                                        <label>Activo</label>
                                                        <Multiselect
                                                            v-model="val.Activo"
                                                            :options="
                                                                options_activo
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'inversiones'">
                                                    <div class="mb-3">
                                                        <label>Inversión</label>
                                                        <Multiselect
                                                            v-model="
                                                                val.Inversion
                                                            "
                                                            :options="
                                                                options_inversion
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'otros'">
                                                    <div class="mb-3">
                                                        <label>Otros</label>
                                                        <Multiselect
                                                            v-model="val.Otro"
                                                            :options="
                                                                options_otro
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div v-if="k == 'trasversales'">
                                                    <div class="mb-3">
                                                        <label
                                                            >Consumos
                                                            transversales</label
                                                        >
                                                        <Multiselect
                                                            v-model="
                                                                val.Trasversal
                                                            "
                                                            :options="
                                                                options_trasversal
                                                            "
                                                            mode="tags"
                                                            valueProp="id"
                                                            label="nombre"
                                                            placeholder="Selección múltiple"
                                                            :searchable="true"
                                                            :disabled="
                                                                !editar_fuente
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                            </div>
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
                            :disabled="!editar_fuente"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
            <div
                v-if="etapa >= 3"
                class="tab-pane fade"
                id="construccion-proceso"
                role="tabpanel"
                aria-labelledby="construccion-proceso-tab"
            >
                <br />
                <form @submit.prevent="guardarProcesos">
                    <div class="mb-3 accordion" id="acordeon-procesos">
                        <div
                            class="accordion-item"
                            v-for="(p, ip) in procesos"
                            v-bind:key="ip"
                        >
                            <h4 class="accordion-header">
                                <button
                                    class="accordion-button border-bottom font-weight-bold collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    :data-bs-target="
                                        '#panelsStayOpen-collapse-' + ip
                                    "
                                    aria-expanded="true"
                                    :aria-controls="
                                        'panelsStayOpen-collapse-' + ip
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
                            </h4>

                            <div
                                :id="'panelsStayOpen-collapse-' + ip"
                                class="accordion-collapse collapse show"
                                :aria-labelledby="
                                    'panelsStayOpen-heading-' + ip
                                "
                            >
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Nombre del proceso</label
                                        >
                                        <input
                                            v-model="p.nombre"
                                            type="text"
                                            class="form-control"
                                            :disabled="!editar_procesos"
                                        />
                                    </div>
                                    <div
                                        style="
                                            padding-left: 30px;
                                            padding-right: 30px;
                                        "
                                        class="accordion"
                                        id="accordionSubprocesos"
                                    >
                                        <div
                                            class="accordion-item"
                                            v-for="(sp, is) in p.subprocesos"
                                            v-bind:key="is"
                                        >
                                            <h5
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
                                            </h5>
                                            <div
                                                :id="'flush-collapse' + ip + is"
                                                class="accordion-collapse collapse show"
                                                :aria-labelledby="
                                                    'flush-heading' + ip + is
                                                "
                                                data-bs-parent="#accordionSubprocesos"
                                            >
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <label class="required"
                                                            >Nombre del sub
                                                            proceso</label
                                                        >
                                                        <input
                                                            v-model="sp.nombre"
                                                            type="text"
                                                            class="form-control"
                                                            :disabled="
                                                                !editar_procesos
                                                            "
                                                            required
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="required"
                                                            >Descripción</label
                                                        >
                                                        <textarea
                                                            v-model="
                                                                sp.descripcion
                                                            "
                                                            class="form-control"
                                                            :disabled="
                                                                !editar_procesos
                                                            "
                                                            required
                                                        ></textarea>
                                                    </div>

                                                    <div class="mb-3 text-end">
                                                        <button
                                                            v-if="is > 0"
                                                            type="button"
                                                            class="btn btn-danger"
                                                            :disabled="
                                                                !editar_procesos
                                                            "
                                                            @click="
                                                                !editar_procesos
                                                                    ? ''
                                                                    : is > 0
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
                                                            Eliminar subproceso
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-success"
                                                            :disabled="
                                                                !editar_procesos
                                                            "
                                                            @click="
                                                                !editar_procesos
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
                                                                              id: '',
                                                                              nombre: '',
                                                                              descripcion:
                                                                                  '',
                                                                          }
                                                                      )
                                                            "
                                                        >
                                                            Agregar nuevo
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
                                            :disabled="!editar_procesos"
                                            @click="
                                                !editar_procesos
                                                    ? ''
                                                    : ip > 0
                                                    ? procesos.splice(ip, 1)
                                                    : ''
                                            "
                                        >
                                            Eliminar proceso
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-success"
                                            :disabled="!editar_procesos"
                                            @click="
                                                !editar_procesos
                                                    ? ''
                                                    : procesos.splice(
                                                          ip + 1,
                                                          0,
                                                          {
                                                              id: '',
                                                              nombre: '',
                                                              subprocesos: [
                                                                  {
                                                                      id: '',
                                                                      nombre: '',
                                                                      descripcion:
                                                                          '',
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
                    <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="!editar_procesos"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>

            <div
                v-if="etapa >= 4"
                class="tab-pane fade"
                id="inicio-consumos"
                role="tabpanel"
                aria-labelledby="inicio-consumos-tab"
            >
                <br />
                <form @submit.prevent="guardarInicioConsumo">
                    <div class="mb-3">
                        <label class="required"
                            >Año de reporte de consumos</label
                        >
                        <Multiselect
                            v-model="ie.anio_inicio"
                            :options="options_anio"
                            valueProp="valor"
                            label="nombre"
                            placeholder="Seleccione una opción"
                            :searchable="true"
                            required
                            :disabled="!editar_inicio"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="required"
                            >Mes de incio de reporte de consumos</label
                        >
                        <Multiselect
                            v-model="ie.mes_inicio"
                            :options="options_mes"
                            valueProp="valor"
                            label="nombre"
                            placeholder="Seleccione una opción"
                            :searchable="true"
                            required
                            :disabled="!editar_inicio"
                        />
                    </div>
                    <div class="mb-3">
                        <label
                            >Unidades producidas o servicios prestados (valor
                            total para todo el periodo, por ejemplo toneladas,
                            botellas, transacciones, etc)</label
                        >
                        <input
                            v-model="ie.unidades_producidas"
                            class="form-control"
                            type="number"
                            :disabled="!editar_inicio"
                        />
                    </div>
                    <div class="mb-3">
                        <label>Tipo de unidad</label>
                        <input
                            v-model="ie.tipo_unidad"
                            class="form-control"
                            type="text"
                            :disabled="!editar_inicio"
                        />
                    </div>
                    <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :disabled="!editar_inicio"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
            <div
                v-if="etapa >= 5"
                class="tab-pane fade"
                id="construccion-anio"
                role="tabpanel"
                aria-labelledby="construccion-anio-tab"
            >
                <br />
                <form @submit.prevent="guardarDatosConsumos">
                    <div class="mb-3 table-responsive">
                        <div class="accordion" id="accordion-categorias">
                            <div
                                class="accordion-item"
                                v-for="(c, i) in filtrarCategorias()"
                                v-bind:key="i"
                            >
                                <p
                                    v-if="c != ''"
                                    style="font-size: 14px"
                                    class="accordion-header"
                                    :id="'heading-categoria-' + i"
                                >
                                    <button
                                        class="accordion-button border-bottom font-weight-bold collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        :data-bs-target="
                                            '#panel-categoria-' + i
                                        "
                                    >
                                        {{ c }}
                                        <i
                                            class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                            aria-hidden="true"
                                        ></i>
                                        <i
                                            class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                            aria-hidden="true"
                                        ></i>
                                    </button>
                                </p>
                                <div
                                    :id="'panel-categoria-' + i"
                                    class="accordion-collapse collapse"
                                >
                                    <div class="accordion-body">
                                        <div
                                            class="accordion"
                                            id="accordion-subcategorias"
                                        >
                                            <div
                                                class="accordion-item"
                                                v-for="(
                                                    sc, si
                                                ) in filtrarSubcategorias(c)"
                                                v-bind:key="si"
                                            >
                                                <p
                                                    style="font-size: 13px"
                                                    class="accordion-header"
                                                    :id="
                                                        'heading-subcategoria-' +
                                                        i +
                                                        si
                                                    "
                                                >
                                                    <button
                                                        class="accordion-button border-bottom font-weight-bold collapsed"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        :data-bs-target="
                                                            '#panel-subcategoria-' +
                                                            i +
                                                            si
                                                        "
                                                    >
                                                        {{ sc }}
                                                        <i
                                                            class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                            aria-hidden="true"
                                                        ></i>
                                                        <i
                                                            class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                            aria-hidden="true"
                                                        ></i>
                                                    </button>
                                                </p>
                                                <div
                                                    :id="
                                                        'panel-subcategoria-' +
                                                        i +
                                                        si
                                                    "
                                                    class="accordion-collapse collapse"
                                                >
                                                    <div class="accordion-body">
                                                        <div
                                                            class="accordion"
                                                            id="accordion-fuentes"
                                                        >
                                                            <div
                                                                class="accordion-item"
                                                                v-for="(
                                                                    fe, fi
                                                                ) in filtrarFuentesEmision(
                                                                    sc
                                                                )"
                                                                v-bind:key="fi"
                                                            >
                                                                <p
                                                                    style="
                                                                        font-size: 12px;
                                                                    "
                                                                    class="accordion-header"
                                                                    :id="
                                                                        'heading-subcategoria-' +
                                                                        i +
                                                                        si +
                                                                        fi
                                                                    "
                                                                >
                                                                    <button
                                                                        class="accordion-button border-bottom font-weight-bold collapsed"
                                                                        type="button"
                                                                        data-bs-toggle="collapse"
                                                                        :data-bs-target="
                                                                            '#panel-fuente-' +
                                                                            i +
                                                                            si +
                                                                            fi
                                                                        "
                                                                    >
                                                                        {{ fe }}
                                                                        <i
                                                                            class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                                            aria-hidden="true"
                                                                        ></i>
                                                                        <i
                                                                            class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                                            aria-hidden="true"
                                                                        ></i>
                                                                    </button>
                                                                </p>
                                                                <div
                                                                    :id="
                                                                        'panel-fuente-' +
                                                                        i +
                                                                        si +
                                                                        fi
                                                                    "
                                                                    class="accordion-collapse collapse"
                                                                >
                                                                    <div
                                                                        class="accordion-body"
                                                                    >
                                                                        <div
                                                                            class="accordion"
                                                                            id="accordion-tipos"
                                                                        >
                                                                            <div
                                                                                class="accordion-item"
                                                                                v-for="(
                                                                                    t,
                                                                                    tk,
                                                                                    ti
                                                                                ) in filtrarTipo(
                                                                                    sc,
                                                                                    fe
                                                                                )"
                                                                                v-bind:key="
                                                                                    tk
                                                                                "
                                                                            >
                                                                                <p
                                                                                    style="
                                                                                        font-size: 12px;
                                                                                    "
                                                                                    class="accordion-header"
                                                                                    :id="
                                                                                        'heading-tipo-' +
                                                                                        i +
                                                                                        si +
                                                                                        fi +
                                                                                        ti
                                                                                    "
                                                                                >
                                                                                    <button
                                                                                        class="accordion-button border-bottom font-weight-bold collapsed"
                                                                                        type="button"
                                                                                        data-bs-toggle="collapse"
                                                                                        :data-bs-target="
                                                                                            '#panel-tipo-' +
                                                                                            i +
                                                                                            si +
                                                                                            fi +
                                                                                            ti
                                                                                        "
                                                                                    >
                                                                                        {{
                                                                                            tk
                                                                                        }}
                                                                                        -
                                                                                        ({{
                                                                                            t
                                                                                        }})
                                                                                        <i
                                                                                            class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                                                            aria-hidden="true"
                                                                                        ></i>
                                                                                        <i
                                                                                            class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                                                            aria-hidden="true"
                                                                                        ></i>
                                                                                    </button>
                                                                                </p>
                                                                                <div
                                                                                    :id="
                                                                                        'panel-tipo-' +
                                                                                        i +
                                                                                        si +
                                                                                        fi +
                                                                                        ti
                                                                                    "
                                                                                    class="accordion-collapse collapse"
                                                                                >
                                                                                    <div
                                                                                        class="accordion-body"
                                                                                    >
                                                                                        <div
                                                                                            v-for="(
                                                                                                fuente,
                                                                                                index
                                                                                            ) in fuentes_emision[
                                                                                                sc
                                                                                            ]"
                                                                                            v-bind:key="
                                                                                                index
                                                                                            "
                                                                                        >
                                                                                            <template
                                                                                                v-if="
                                                                                                    fuente
                                                                                                        .fuentetable
                                                                                                        .nombre ==
                                                                                                        tk &&
                                                                                                    fuente.fuente_emision !=
                                                                                                        'Transporte_aereo'
                                                                                                "
                                                                                            >
                                                                                                <div
                                                                                                    class="mb-3"
                                                                                                    v-for="(
                                                                                                        ac,
                                                                                                        ci
                                                                                                    ) in array_consumos"
                                                                                                    v-bind:key="
                                                                                                        ci
                                                                                                    "
                                                                                                >
                                                                                                    <template
                                                                                                        v-if="
                                                                                                            fuente
                                                                                                                .fuentetable
                                                                                                                .nombre ==
                                                                                                            tk
                                                                                                        "
                                                                                                    >
                                                                                                        <label>
                                                                                                            {{
                                                                                                                ac.includes(
                                                                                                                    "FUENTE"
                                                                                                                )
                                                                                                                    ? ac +
                                                                                                                      " DE CONSUMO"
                                                                                                                    : ac
                                                                                                            }}

                                                                                                            <i
                                                                                                                v-if="
                                                                                                                    ac.includes(
                                                                                                                        'INCERTIDUMBRE'
                                                                                                                    )
                                                                                                                "
                                                                                                                class="fas fa-question-circle fas-2x"
                                                                                                                :ref="
                                                                                                                    'popoverTrigger' +
                                                                                                                    index +
                                                                                                                    ci
                                                                                                                "
                                                                                                                @click="
                                                                                                                    togglePopover(
                                                                                                                        'popoverTrigger' +
                                                                                                                            index +
                                                                                                                            ci
                                                                                                                    )
                                                                                                                "
                                                                                                            ></i>
                                                                                                            <div
                                                                                                                ref="popoverContent"
                                                                                                                class="d-none"
                                                                                                            >
                                                                                                                <p>
                                                                                                                    Texto
                                                                                                                    de
                                                                                                                    ayuda
                                                                                                                </p>
                                                                                                            </div>
                                                                                                            <small
                                                                                                                v-if="
                                                                                                                    ac.includes(
                                                                                                                        'FUENTE'
                                                                                                                    )
                                                                                                                "
                                                                                                            >
                                                                                                                Por
                                                                                                                ejemplo:
                                                                                                                (Caldera,
                                                                                                                montacarga,
                                                                                                                camión,
                                                                                                                procesadora
                                                                                                                etc)
                                                                                                            </small>
                                                                                                        </label>
                                                                                                        <input
                                                                                                            v-if="
                                                                                                                ac.includes(
                                                                                                                    'CONSUMO'
                                                                                                                ) &&
                                                                                                                fuente.fuente_emision !=
                                                                                                                    'Transporte_aereo'
                                                                                                            "
                                                                                                            v-model="
                                                                                                                fuente
                                                                                                                    .resultado[
                                                                                                                    'dato_' +
                                                                                                                        (ci +
                                                                                                                            1)
                                                                                                                ]
                                                                                                            "
                                                                                                            class="form-control"
                                                                                                            type="number"
                                                                                                            step="any"
                                                                                                            @change="
                                                                                                                fuente.tipo ==
                                                                                                                    'fuentes_moviles' ||
                                                                                                                'fuentes_fijas' ||
                                                                                                                'energia_importada' ||
                                                                                                                'transportes_fuentes_moviles'
                                                                                                                    ? agregarDatosFuenteBiogenica(
                                                                                                                          fuente.tipo,
                                                                                                                          fuente.fuentetable_id,
                                                                                                                          'dato_' +
                                                                                                                              (ci +
                                                                                                                                  1)
                                                                                                                      )
                                                                                                                    : ''
                                                                                                            "
                                                                                                            :disabled="
                                                                                                                !editar_consumos
                                                                                                            "
                                                                                                        />
                                                                                                        <input
                                                                                                            v-if="
                                                                                                                ac.includes(
                                                                                                                    'CONSUMO'
                                                                                                                ) &&
                                                                                                                fuente.fuente_emision ==
                                                                                                                    'Transporte_aereo'
                                                                                                            "
                                                                                                            v-model="
                                                                                                                fuente
                                                                                                                    .resultado[
                                                                                                                    'dato_' +
                                                                                                                        (1 +
                                                                                                                            1)
                                                                                                                ]
                                                                                                            "
                                                                                                            class="form-control"
                                                                                                            type="number"
                                                                                                            step="any"
                                                                                                            :disabled="
                                                                                                                !editar_consumos
                                                                                                            "
                                                                                                        />
                                                                                                        <input
                                                                                                            v-else-if="
                                                                                                                ac.includes(
                                                                                                                    'INCERTIDUMBRE'
                                                                                                                ) &&
                                                                                                                fuente.fuente_emision !=
                                                                                                                    'Transporte_aereo'
                                                                                                            "
                                                                                                            v-model="
                                                                                                                fuente
                                                                                                                    .resultado[
                                                                                                                    'incertidumbre_sistematica_adicional'
                                                                                                                ]
                                                                                                            "
                                                                                                            class="form-control"
                                                                                                            type="number"
                                                                                                            step="any"
                                                                                                            :disabled="
                                                                                                                !editar_consumos
                                                                                                            "
                                                                                                        />
                                                                                                        <input
                                                                                                            v-else-if="
                                                                                                                ac.includes(
                                                                                                                    'FUENTE'
                                                                                                                ) &&
                                                                                                                fuente.fuente_emision !=
                                                                                                                    'Transporte_aereo'
                                                                                                            "
                                                                                                            v-model="
                                                                                                                fuente
                                                                                                                    .resultado[
                                                                                                                    'descripcion_fuente_emision'
                                                                                                                ]
                                                                                                            "
                                                                                                            class="form-control"
                                                                                                            type="text"
                                                                                                            :disabled="
                                                                                                                !editar_consumos
                                                                                                            "
                                                                                                        />
                                                                                                    </template>
                                                                                                </div>
                                                                                            </template>
                                                                                            <template
                                                                                                v-if="
                                                                                                    fuente
                                                                                                        .fuentetable
                                                                                                        .nombre ==
                                                                                                        tk &&
                                                                                                    fuente.fuente_emision ==
                                                                                                        'Transporte_aereo'
                                                                                                "
                                                                                            >
                                                                                                <div
                                                                                                    class="mb-3"
                                                                                                >
                                                                                                    <label
                                                                                                        >CONSUMO
                                                                                                        TOTAL
                                                                                                        <small
                                                                                                            >(Ingrese
                                                                                                            total
                                                                                                            de
                                                                                                            kilogramos
                                                                                                            de
                                                                                                            CO2
                                                                                                            generados
                                                                                                            por
                                                                                                            viajes
                                                                                                            aéreos
                                                                                                            de
                                                                                                            pasajeros
                                                                                                            en
                                                                                                            el
                                                                                                            periodo).
                                                                                                            Para
                                                                                                            calcular
                                                                                                            el
                                                                                                            valor
                                                                                                            de
                                                                                                            cada
                                                                                                            viaje
                                                                                                            ingrese
                                                                                                            <a
                                                                                                                href="https://www.icao.int/environmental-protection/CarbonOffset/Pages/default.aspx"
                                                                                                                target="_blank"
                                                                                                                style="
                                                                                                                    color: #208943;
                                                                                                                "
                                                                                                                >AQUÍ</a
                                                                                                            ></small
                                                                                                        ></label
                                                                                                    >
                                                                                                    <input
                                                                                                        v-model="
                                                                                                            fuente
                                                                                                                .resultado[
                                                                                                                'dato_1'
                                                                                                            ]
                                                                                                        "
                                                                                                        class="form-control"
                                                                                                        type="number"
                                                                                                        step="any"
                                                                                                        :disabled="
                                                                                                            !editar_consumos
                                                                                                        "
                                                                                                    />
                                                                                                </div>
                                                                                            </template>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="!editar_consumos"
                            >
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import Parametro from "../../models/Parametro";
import Empresa from "../../models/Empresa";
import EmpresaSede from "../../models/EmpresaSede";
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
import Producto from "../../models/Producto";
import User from "../../models/User";
import Trasversal from "../../models/Trasversal";
import Otro from "../../models/Otro";
import ResultadoFuenteEmision from "../../models/ResultadoFuenteEmision";

export default {
    data() {
        return {
            ie: new InformacionEmpresa({}),
            empresa_id: "",
            sede_id: "",
            ie_id: "", //informacion empresa

            etapa: 1,
            paso: 1,

            ac: {
                c1: "CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI",
                c2: "CATEGORIA 2 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR CONSUMO DE ENERGÍA",
                c3: "CATEGORIA 3 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR EL TRANSPORTE",
                c4: "CATEGORIA 4 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR PRODUCTOS QUE UTILIZA LA ORGANIZACIÓN",
                c5: "CATEGORIA 5 - EMISIONES INDIRECTAS DE GEI ASOCIADAS CON EL USO DE LOS PRODUCTOS DE LA ORGANIZACIÓN",
                c6: "CATEGORIA 6 - EMISIONES INDIRECTAS DE GEI PROVENIENTES DE OTRAS FUENTES",
                c7: "CATEGORIA 7 - EMISIONES TRANSVERSALES",
            },

            asc: {
                fuentes_fijas: "FUENTES FIJAS",
                fuentes_moviles: "FUENTES MÓVILES",
                emisiones: "EMISIONES DE PROCESO",
                electricidad_importada: "ELECTRICIDAD IMPORTADA",
                energia_importada: "ENERGÍA IMPORTADA (TÉRMICA)",
                transportes_fuentes_moviles: "FUENTES MÓVILES",
                transportes_carga_pasajeros: "TRANSPORTE CARGA Y PASAJEROS",
                bienes_productos: "BIENES Y PRODUCTOS",
                servicios: "SERVICIOS",
                usos: "USO DE PRODUCTOS",
                fines: "FIN DE VIDA",
                activos: "ACTIVOS ARRENDADOS",
                inversiones: "INVERSIONES",
                otros: "Otros",
                trasversales: "Trasversales",
                fuentes_moviles_biogenico: "FUENTES MÓVILES BIOGÉNICO",
                fuentes_fijas_biogenico: "FUENTES FIJAS BIOGÉNICO",
                energia_importada_biogenico: "ENERGIA IMPORTADA BIOGÉNICO",
                transportes_fuentes_moviles_biogenico:
                    "TRASPORTES FUENTES MÓVILES BIOGÉNICO",
            },

            fuentes: "",
            procesos: [
                {
                    id: "",
                    nombre: "",
                    subprocesos: [
                        {
                            id: "",
                            nombre: "",
                            descripcion: "",
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

            options_empresa: [],
            options_sede: [],
            options_ie: [],

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
            options_pasajero: [],
            options_carga: [],
            options_aereo: [],
            options_producto: [],
            options_equipo: [],
            options_materia_prima: [],
            options_servicio: [],
            options_uso: [],
            options_destino: [],
            options_activo: [],
            options_inversion: [],
            options_trasversal: [],
            options_otro: [],
            options_equipo_consumo: [],
            options_metodologia: [],
            options_anio: [],
            options_mes: [],
            bsPopover: null,
            editar_formulario: 1,
            editar_fuente: 1,
            editar_procesos: 1,
            editar_inicio: 1,
            editar_consumos: 1,
            informacion_empresa_existe: true,
            huella_existe: 0,
            mostrar_formulario: false,
            huellas: [],
            nombre_huella: "",
            permiso_huella: "",
            user: new User(),
        };
    },
    mounted() {
        this.getUserLogged();
        this.getParametros(7, "options_anio");
        this.getParametros(8, "options_mes");
        this.getParametros(12, "options_metodologia");
        this.cargarVariableFuentes();
        this.getOptionsFuenteEmision();
    },
    methods: {
        tabActiva() {
            setTimeout(() => {
                switch (this.etapa) {
                    case 1:
                        $("#formulario-tab").click();
                        break;
                    case 2:
                        $("#seleccion-tab").click();
                        break;
                    case 3:
                        $("#construccion-proceso-tab").click();
                        break;
                    case 4:
                        $("#inicio-consumos-tab").click();
                        break;
                    case 5:
                        $("#construccion-anio-tab").click();
                        break;
                }
                Swal.close();
            }, 2500);
        },
        async getUserLogged() {
            await axios
                .get("api/user")
                .then((response) => {
                    this.user = response.data;
                    this.getSedeUser();
                    if (this.user.rol_id == 2) {
                        this.empresa_id = this.user.empresa_id;
                        this.sede_id = this.user.sede_id;
                        this.huellaExiste();
                        this.getHuellas();
                    } else {
                        this.getOptionsEmpresa();
                    }
                })
                .catch((error) => {});
        },

        async getSedeUser() {
            let data = await User.include("empresaSede").find(this.user.id);
            this.permiso_huella = data.empresa_sede.permiso_huella;
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
        async getOptionsEmpresa() {
            this.options_empresa = await Empresa.get();
        },
        async getOptionsSede() {
            this.options_sede = [];
            this.sede_id = "";
            this.options_ie = [];
            this.ie_id = "";

            if (this.empresa_id != "" && this.empresa_id != null) {
                this.options_sede = await EmpresaSede.where(
                    "empresa_id",
                    this.empresa_id
                ).get();
            }
        },
        async getOptionsPeriodo() {
            this.options_ie = [];
            this.ie_id = "";
            if (this.sede_id != "" && this.sede_id != null) {
                let informacion_empresa = await InformacionEmpresa.where(
                    "sede_id",
                    this.sede_id
                ).get();

                informacion_empresa.forEach((e) => {
                    if (e.anio_inicio != null) {
                        let fecha_base = new Date(
                            e.anio_inicio + "-" + e.mes_inicio + "-01 00:00"
                        );

                        var future = new Date(
                            fecha_base.getFullYear(),
                            fecha_base.getMonth() + 12,
                            1
                        );

                        let mes_fecha_base =
                            this.array_meses[fecha_base.getMonth()];

                        var mes_futuro = this.array_meses[future.getMonth()];
                        var anio_futuro = future.getFullYear();

                        var json = {
                            value: e.id,
                            label:
                                mes_fecha_base +
                                " " +
                                e.anio_inicio +
                                " a " +
                                mes_futuro +
                                " " +
                                anio_futuro,
                        };
                        this.options_ie.push(json);
                    }
                });
            }
        },

        async getHuellas() {
            this.huellas = await InformacionEmpresa.where(
                "sede_id",
                this.sede_id
            ).get();

            if (this.huellas.length == 0) {
                this.etapa = 1;
                this.recargarFormularioEmisiones();
                this.tabActiva();
            } else {
                this.huellas.forEach((e) => {
                    let fecha_base = new Date(
                        e.anio_inicio + "-" + e.mes_inicio + "-01 00:00"
                    );

                    var future = new Date(
                        fecha_base.getFullYear(),
                        fecha_base.getMonth() + 11,
                        1
                    );

                    let mes_fecha_base =
                        this.array_meses[fecha_base.getMonth()];

                    var mes_futuro = this.array_meses[future.getMonth()];
                    var anio_futuro = future.getFullYear();
                    e["periodo"] =
                        mes_fecha_base +
                        " " +
                        e.anio_inicio +
                        " a " +
                        mes_futuro +
                        " " +
                        anio_futuro;
                });
            }
        },

        async getOptionsFuenteEmision() {
            this.$root.mostrarCargando("Cargando fuentes de consumo");
            let combustibles = await Combustible.get();

            this.filtroArrayOpciones(
                combustibles,
                "options_combustible_solido",
                "solido"
            );
            this.filtroArrayOpciones(
                combustibles,
                "options_combustible_liquido",
                "liquido"
            );
            this.filtroArrayOpciones(
                combustibles,
                "options_combustible_gaseoso",
                "gaseoso"
            );

            this.options_refrigerante = await Refrigerante.get();
            this.options_extintor = await Extintor.get();
            this.options_lubricante = await Lubricante.get();
            this.options_fuga = await Fuga.get();
            this.options_aislamiento = await Aislamiento.get();

            let emisiones = await Emision.get();

            this.filtroArrayOpciones(emisiones, "options_embalse", "embalse");
            this.filtroArrayOpciones(emisiones, "options_mineria", "mineria");
            this.filtroArrayOpciones(
                emisiones,
                "options_industrial",
                "industrial"
            );
            this.filtroArrayOpciones(
                emisiones,
                "options_residuo_organizacional",
                "residuo"
            );

            this.options_fermentacion = await Fermentacion.get();

            let estiercoles = await Estiercol.get();

            this.filtroArrayOpciones(
                estiercoles,
                "options_estiercol",
                "estiercol"
            );
            this.filtroArrayOpciones(
                estiercoles,
                "options_residuo_agropecuario",
                "residuo"
            );

            let fertilizantes = await Fertilizante.get();

            this.filtroArrayOpciones(
                fertilizantes,
                "options_fertilizante",
                "fertilizante"
            );
            this.filtroArrayOpciones(fertilizantes, "options_cal", "cal");

            this.options_electricidad = await Electricidad.get();

            let viajes = await Viaje.get();

            this.filtroArrayOpciones(viajes, "options_pasajero", "pasajero");
            this.filtroArrayOpciones(viajes, "options_carga", "carga");
            this.filtroArrayOpciones(viajes, "options_aereo", "aereo");

            let productos = await Producto.get();
            this.filtroArrayOpciones(
                productos,
                "options_producto",
                "utiliza",
                "producto"
            );
            this.filtroArrayOpciones(
                productos,
                "options_equipo",
                "utiliza",
                "equipo"
            );
            this.filtroArrayOpciones(
                productos,
                "options_materia_prima",
                "utiliza",
                "materia_prima"
            );
            this.filtroArrayOpciones(
                productos,
                "options_servicio",
                "utiliza",
                "servicio"
            );
            this.filtroArrayOpciones(productos, "options_uso", "uso", "uso");
            this.filtroArrayOpciones(
                productos,
                "options_destino",
                "uso",
                "destino"
            );
            this.filtroArrayOpciones(
                productos,
                "options_activo",
                "uso",
                "activo"
            );
            this.filtroArrayOpciones(
                productos,
                "options_inversion",
                "uso",
                "inversion"
            );

            this.options_trasversal = await Trasversal.get();
            this.options_otro = await Otro.get();

            Swal.close();
        },
        filtroArrayOpciones(array, variable, tipo, subtipo = "") {
            if (subtipo == "") {
                this[variable] = array.filter((el) => el.tipo === tipo);
            } else {
                this[variable] = array.filter(
                    (el) => el.tipo === tipo && el.subtipo === subtipo
                );
            }
        },
        filtrarCategorias() {
            let categorias = [];

            Object.keys(this.fuentes_emision).forEach((key) => {
                Object.keys(this.fuentes_emision[key]).forEach((k) => {
                    categorias.push(
                        this.fuentes_emision[key][k]["categoria_mostrar"]
                    );
                });
            });

            categorias = categorias.filter((v, i, s) => {
                return s.indexOf(v) === i;
            });

            categorias.sort();
            return categorias;
        },
        filtrarSubcategorias(categoria) {
            let subcategorias = [];

            Object.keys(this.fuentes_emision).forEach((key) => {
                Object.keys(this.fuentes_emision[key]).forEach((k) => {
                    if (
                        this.fuentes_emision[key][k]["categoria_mostrar"] ==
                        categoria
                    ) {
                        subcategorias.push(
                            this.fuentes_emision[key][k]["tipo_mostrar"]
                        );
                    }
                });
            });

            subcategorias = subcategorias.filter((v, i, s) => {
                return s.indexOf(v) === i;
            });

            return subcategorias;
        },
        filtrarFuentesEmision(subcategoria) {
            let fuentes = [];

            Object.keys(this.fuentes_emision).forEach((key) => {
                Object.keys(this.fuentes_emision[key]).forEach((k) => {
                    if (
                        this.fuentes_emision[key][k]["tipo_mostrar"] ==
                        subcategoria
                    ) {
                        fuentes.push(
                            this.fuentes_emision[key][k][
                                "fuente_emision_mostrar"
                            ]
                        );
                    }
                });
            });

            fuentes = fuentes.filter((v, i, s) => {
                return s.indexOf(v) === i;
            });

            return fuentes;
        },
        filtrarTipo(tipo, fuente) {
            let tipos = {};

            Object.keys(this.fuentes_emision).forEach((key) => {
                Object.keys(this.fuentes_emision[key]).forEach((k) => {
                    if (
                        this.fuentes_emision[key][k]["tipo_mostrar"] == tipo &&
                        this.fuentes_emision[key][k][
                            "fuente_emision_mostrar"
                        ] == fuente
                    ) {
                        tipos[
                            this.fuentes_emision[key][k]["fuentetable"][
                                "nombre"
                            ]
                        ] =
                            this.fuentes_emision[key][k]["fuentetable"][
                                "unidad_consumo"
                            ];
                    }
                });
            });
            return tipos;
        },
        changeMetodologia() {
            this.ie.otra_metodologia = null;
            let option = this.options_metodologia.filter(
                (el) => el.id === this.ie.metodologia
            );
            this.valor_option_metodologia = option[0]["valor"];
        },

        async guardarInformacion(e) {
            if (this.paso == 1) {
                if (this.ie.huella_base == 0) {
                    this.paso = 3;
                } else {
                    this.paso++;
                }
            } else {
                if (!this.editar_formulario && this.paso == 4) {
                    this.paso = 4;
                } else {
                    this.paso++;
                }
            }

            if (this.paso == 5 && this.editar_formulario) {
                this.$root.mostrarCargando("Guardando información");

                await this.ie.save();

                Swal.close();
                this.$root.mostrarMensaje(
                    "Guardado con éxito",
                    "Información guardada exitosamente",
                    "success"
                );
                this.recargarFormularioEmisiones();
                setTimeout(() => {
                    $("#seleccion-tab").click();
                }, 500);
            }
        },
        guardarFuentesEmision() {
            if (this.editar_fuente) {
                this.$root.mostrarCargando("Guardando información");

                let actualizar = this.user.rol_id == 2 ? 0 : 1;

                axios
                    .post("api/guardarFuentesEmision", {
                        fuentes: this.fuentes,
                        empresa_id: this.empresa_id,
                        sede_id: this.sede_id,
                        informacion_empresa_id: this.ie.id,
                        actualizar: actualizar,
                    })
                    .then((response) => {
                        Swal.close();
                        this.$root.mostrarMensaje(
                            "Guardado con éxito",
                            "Información guardada exitosamente",
                            "success"
                        );
                        this.recargarFuentesEmision();
                        setTimeout(() => {
                            $("#construccion-proceso-tab").click();
                        }, 500);
                    })
                    .catch((error) => {});
            }
        },

        async guardarProcesos() {
            if (this.editar_procesos) {
                this.$root.mostrarCargando("Guardando información");

                let actualizar = this.user.rol_id == 2 ? 0 : 1;

                axios
                    .post("/api/guardarProcesos", {
                        procesos: this.procesos,
                        empresa_id: this.empresa_id,
                        sede_id: this.sede_id,
                        informacion_empresa_id: this.ie.id,
                        actualizar: actualizar,
                    })
                    .then((response) => {
                        Swal.close();
                        this.$root.mostrarMensaje(
                            "Guardado con éxito",
                            "Información guardada exitosamente",
                            "success"
                        );
                        this.recargarProcesos();
                        setTimeout(() => {
                            $("#inicio-consumos-tab").click();
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

        async guardarInicioConsumo() {
            if (this.editar_inicio) {
                this.$root.mostrarCargando("Guardando información");
                await this.ie.save();

                Swal.close();
                this.$root.mostrarMensaje(
                    "Guardado con éxito",
                    "Información guardada exitosamente",
                    "success"
                );
                this.recargarInformacionInicio();
                setTimeout(() => {
                    $("#construccion-anio-tab").click();
                }, 500);
            }
        },

        async guardarDatosConsumos() {
            if (this.editar_consumos) {
                let texto_adicional =
                    this.user.rol_id == 2
                        ? ", una vez guardados no podrá modificarlos."
                        : "";
                Swal.fire({
                    title: "Atención",
                    html:
                        "¿Está seguro que quiere guardar los datos?" +
                        texto_adicional,
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    confirmButtonText: "Si, guardar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$root.mostrarCargando("Guardando información");
                        try {
                            axios
                                .post("api/guardarDatosConsumos", {
                                    fuentes_emision: this.fuentes_emision,
                                })
                                .then((response) => {
                                    Swal.close();
                                    this.$root.mostrarMensaje(
                                        "Guardado con éxito",
                                        "Información guardada exitosamente",
                                        "success"
                                    );
                                    setTimeout(() => {
                                        this.$root.redirectIndex("/resultados");
                                    }, 100);
                                });
                        } catch (error) {
                            this.$root.mostrarMensaje(
                                "Error",
                                "Ha ocurrido un error al guardar los datos de consumos, por favor intentelo nuevamente",
                                "error"
                            );
                        }
                    }
                });
            }
        },

        async huellaExiste() {
            let informacionEmpresa = await InformacionEmpresa.where({
                empresa_id: this.empresa_id,
                sede_id: this.sede_id,
                id: this.ie_id,
            }).first();

            if (Object.keys(informacionEmpresa).length != 0) {
                this.huella_existe = 1;
            }
        },

        async recargarFormularioEmisiones() {
            this.$root.mostrarCargando("Cargando información");

            this.editar_formulario = 1;

            this.mostrar_formulario = true;
            if (!this.user.empresa_id) {
                await this.getUserLogged();
            }

            let json = {
                empresa_id: this.empresa_id,
                sede_id: this.sede_id,
            };

            if (this.ie_id == "") {
                json.estado = 1;
            } else {
                json.id = this.ie_id;
            }

            let informacionEmpresa = await InformacionEmpresa.where(
                json
            ).first();

            this.ie =
                informacionEmpresa &&
                Object.keys(informacionEmpresa).length != 0
                    ? informacionEmpresa
                    : this.ie;

            if (informacionEmpresa.huella_base != null) {
                this.paso = 1;
                this.huella_existe = 1;
                this.editar_formulario = this.user.rol_id == 2 ? 0 : 1;
                this.etapa = 2;
                this.recargarFuentesEmision();
            } else {
                this.etapa = 1;
                this.ie.empresa_id = this.empresa_id;
                this.ie.sede_id = this.sede_id;
            }
        },
        async recargarFuentesEmision() {
            this.editar_fuente = 1;
            axios
                .post("/api/recargarFuentesEmision", {
                    empresa_id: this.empresa_id,
                    sede_id: this.sede_id,
                    informacion_empresa_id: this.ie.id,
                })
                .then((response) => {
                    if (response.data.length != 0) {
                        this.fuentes = response.data;
                        this.etapa = 3;
                        this.recargarProcesos();
                    } else {
                        this.cargarVariableFuentes();
                        Swal.close();
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
        async recargarProcesos() {
            this.editar_procesos = 1;
            this.procesos = [
                {
                    id: "",
                    nombre: "",
                    subprocesos: [
                        {
                            id: "",
                            nombre: "",
                            descripcion: "",
                        },
                    ],
                },
            ];
            axios
                .post("/api/recargarProcesos", {
                    empresa_id: this.empresa_id,
                    sede_id: this.sede_id,
                    informacion_empresa_id: this.ie.id,
                })
                .then((response) => {
                    if (response.data.length != 0) {
                        this.procesos = response.data;
                        this.etapa = 4;
                        this.recargarInformacionInicio();
                    } else {
                        Swal.close();
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
            this.editar_inicio = 1;
            let informacionEmpresa = await InformacionEmpresa.find(this.ie.id);

            if (informacionEmpresa.anio_inicio != null) {
                this.etapa = 5;
                this.getFuentesEmision();
            } else {
                Swal.close();
            }
        },

        async tablaEmisiones() {
            this.array_consumos = [];
            let informacion_empresa = await InformacionEmpresa.find(this.ie.id);

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
            this.array_consumos.push("INCERTIDUMBRE SISTEMÁTICA ADICIONAL");
            this.array_consumos.push("FUENTE");
        },
        async getFuentesEmision() {
            this.editar_consumos = 1;

            axios
                .post("api/getFuentesEmision", {
                    empresa_id: this.empresa_id,
                    sede_id: this.sede_id,
                    informacion_empresa_id: this.ie.id,
                })
                .then((response) => {
                    let r = response.data;
                    Object.keys(r).forEach((key) => {
                        Object.keys(r[key]).forEach((k) => {
                            if (r[key][k]["resultado"]["id"] != "") {
                                if (this.user.rol_id == 2) {
                                    this.editar_fuente = 0;
                                    this.editar_procesos = 0;
                                    this.editar_inicio = 0;
                                    this.editar_consumos = 0;
                                }
                            }
                        });
                    });

                    this.fuentes_emision = response.data;
                    Swal.close();
                })
                .catch((error) => {});

            this.tablaEmisiones();
        },
        cargarVariableFuentes() {
            this.fuentes = {
                c1: {
                    fuentes_moviles: {
                        Combustible_liquido: [],
                        Combustible_gaseoso: [],
                        Refrigerante: [],
                        Extintor: [],
                        Lubricante: [],
                    },
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
                    emisiones: {
                        Embalse: [],
                        Mineria: [],
                        Industrial: [],
                        Fermentacion: [],
                        Estiercol: [],
                        Residuo_organizacional: [],
                        Residuo_agropecuario: [],
                        Fertilizante: [],
                        Cal: [],
                    },
                    fuentes_moviles_biogenico_26: { Combustible_liquido: [] },
                    fuentes_moviles_biogenico_37: { Combustible_liquido: [] },
                    fuentes_moviles_biogenico_27: { Combustible_liquido: [] },
                    fuentes_moviles_biogenico_38: { Combustible_liquido: [] },
                    fuentes_fijas_biogenico_26: { Combustible_liquido: [] },
                    fuentes_fijas_biogenico_37: { Combustible_liquido: [] },
                    fuentes_fijas_biogenico_27: { Combustible_liquido: [] },
                    fuentes_fijas_biogenico_38: { Combustible_liquido: [] },
                },

                c2: {
                    electricidad_importada: {
                        Energia_electrica: [],
                    },
                    energia_importada: {
                        Combustible_solido: [],
                        Combustible_liquido: [],
                        Combustible_gaseoso: [],
                    },
                    energia_importada_biogenico_26: { Combustible_liquido: [] },
                    energia_importada_biogenico_37: { Combustible_liquido: [] },
                    energia_importada_biogenico_27: { Combustible_liquido: [] },
                    energia_importada_biogenico_38: { Combustible_liquido: [] },
                },

                c3: {
                    transportes_fuentes_moviles: {
                        Combustible_solido: [],
                        Combustible_liquido: [],
                        Combustible_gaseoso: [],
                        Refrigerante: [],
                        Extintor: [],
                        Lubricante: [],
                    },

                    transportes_carga_pasajeros: {
                        Transporte_carga: [],
                        Transporte_pasajeros: [],
                        Transporte_aereo: [],
                    },

                    transportes_fuentes_moviles_biogenico_26: {
                        Combustible_liquido: [],
                    },
                    transportes_fuentes_moviles_biogenico_37: {
                        Combustible_liquido: [],
                    },
                    transportes_fuentes_moviles_biogenico_27: {
                        Combustible_liquido: [],
                    },
                    transportes_fuentes_moviles_biogenico_38: {
                        Combustible_liquido: [],
                    },
                },
                c4: {
                    bienes_productos: {
                        Refrigerante: [],
                        Extintor: [],
                        Lubricante: [],
                        Aislamiento: [],
                        Producto: [],
                        Equipo: [],
                        Materia_prima: [],
                    },
                    servicios: {
                        Servicio: [],
                        Residuo_organizacional: [],
                    },
                },
                c5: {
                    usos: {
                        Producto: [],
                    },
                    fines: {
                        Fin: [],
                    },
                    activos: {
                        Activo: [],
                    },
                    inversiones: {
                        Inversion: [],
                    },
                },
                c6: {
                    otros: {
                        Otro: [],
                    },
                },
                c7: {
                    trasversales: {
                        Trasversal: [],
                    },
                },
            };
        },
        async nuevaHuella() {
            Swal.fire({
                title: "Atención",
                html: "¿Está seguro que quiere registrar una nueva huella?",
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Si",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$root.mostrarCargando("Generando nueva huella");
                    try {
                        this.verificarHuellaFinalizada();
                    } catch (error) {
                        this.$root.mostrarMensaje(
                            "Error",
                            "Ha ocurrido un error al generar una nueva huella, por favor intentelo nuevamente",
                            "error"
                        );
                    }
                }
            });
        },
        async verificarHuellaFinalizada() {
            let informacion_empresa = await InformacionEmpresa.where({
                empresa_id: this.empresa_id,
                sede_id: this.sede_id,
                estado: 1,
            }).first();

            this.ie_id = informacion_empresa.id;

            let resultados = await ResultadoFuenteEmision.where(
                "informacion_empresa_id",
                this.ie_id
            ).get();

            if (resultados.length == 0) {
                Swal.close();
                this.$root.mostrarMensaje(
                    "Atención",
                    "No puede crear una nueva huella hasta que no finalice la huella actual",
                    "warning"
                );
            } else {
                this.desactivarHuellaActual();
            }
        },
        async desactivarHuellaActual() {
            let informacion_empresa = await InformacionEmpresa.find(this.ie_id);
            informacion_empresa.estado = 0;
            informacion_empresa.save();

            let sede = await EmpresaSede.find(informacion_empresa.sede_id);
            sede.permiso_huella = 0;
            await sede.save();

            this.getSedeUser();

            this.ie = new InformacionEmpresa({});
            this.ie.empresa_id = this.empresa_id;
            this.ie.sede_id = this.sede_id;
            this.ie.usuario_creacion_id = this.user.id;
            this.ie.estado = 1;
            this.ie.save();
            this.ie_id = "";

            setTimeout(() => {
                this.$root.mostrarMensaje(
                    "Guardado con éxito",
                    "Huella generada correctamente",
                    "success"
                );
                this.getHuellas();
            }, 500);

            setTimeout(() => {
                this.$refs["huellaActiva"][0].click();
            }, 1000);

            Swal.close();
        },
        agregarFuenteBiogenico(key, k, val) {
            let array = [26, 27, 37, 38];
            array.forEach((e) => {
                let id_fuente = e == 26 || e == 37 ? 33 : 34;
                if (val.Combustible_liquido.includes(e)) {
                    if (
                        !this.fuentes[key][k + "_biogenico_" + e][
                            "Combustible_liquido"
                        ].includes(id_fuente)
                    ) {
                        this.fuentes[key][k + "_biogenico_" + e][
                            "Combustible_liquido"
                        ].push(id_fuente);
                    }
                } else {
                    let index =
                        this.fuentes[key][k + "_biogenico_" + e][
                            "Combustible_liquido"
                        ].indexOf(id_fuente);
                    if (index > -1) {
                        this.fuentes[key][k + "_biogenico_" + e][
                            "Combustible_liquido"
                        ].splice(index, 1);
                    }
                }
            });
        },
        agregarDatosFuenteBiogenica(tipo, fuentetable_id, dato) {
            let resultado = 0;
            Object.keys(this.fuentes_emision).forEach((key) => {
                Object.keys(this.fuentes_emision[key]).forEach((k) => {
                    if (
                        this.fuentes_emision[key][k]["tipo"] == tipo &&
                        this.fuentes_emision[key][k]["fuentetable_id"] ==
                            fuentetable_id
                    ) {
                        resultado =
                            this.fuentes_emision[key][k]["resultado"][dato];
                    }
                });
            });

            Object.keys(this.fuentes_emision).forEach((key) => {
                Object.keys(this.fuentes_emision[key]).forEach((k) => {
                    if (
                        this.fuentes_emision[key][k]["tipo"] == tipo &&
                        this.fuentes_emision[key][k]["fuentetable_id"] ==
                            fuentetable_id
                    ) {
                    }

                    if (
                        this.fuentes_emision[key][k]["tipo"] ==
                        tipo + "_biogenico_" + fuentetable_id
                    ) {
                        this.fuentes_emision[key][k]["resultado"][dato] =
                            resultado;
                    }
                });
            });
        },
        togglePopover(el) {
            $(this.$refs[el]).popover({
                content: $(this.$refs.popoverContent).html(),
                html: true,
            });
            $(this.$refs[el]).popover("toggle");
        },
    },
};
</script>
<style>
textarea.form-control {
    max-height: 80px;
    min-height: 80px;
}
#tabs-ingresar-datos .nav-link.active {
    color: #fff !important;
    background-color: #2ec761 !important;
}
#tabs-ingresar-datos .nav-link.active span {
    display: contents;
}
#tabs-ingresar-datos .nav-link span {
    display: none;
}
#tabs-ingresar-datos .nav-link {
    color: #000 !important;
    background-color: #f8f9fa !important;
}
.nav-pills .nav-link {
    border: 1px solid #2ec761;
}
#tabs-ingresar-datos .nav-link:hover,
#tabs-ingresar-datos .nav-link:focus {
    color: #000;
}
#tabs-ingresar-datos {
    background-color: transparent !important;
}
</style>
