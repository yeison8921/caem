<template>
  <div>
    <div class="pt-7 card">
      <div class="card-body">
        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <span
              class="badge rounded-pill"
              :class="paso == 1 ? 'active bg-primary' : 'bg-secondary'"
              id="pills-correo-tab"
              >1</span
            >
                <li class="nav-item" role="presentation">
                    <span
                        class="badge rounded-pill"
                        :class="
                            paso == 1 ? 'active bg-primary' : 'bg-secondary'
                        "
                        id="pills-correo-tab"
                        >1</span
                    >
                    Correo
                </li>
                <li class="nav-item" role="presentation">
                    <span
                        class="badge bg-primary rounded-pill"
                        :class="
                            paso == 2 ? 'active bg-primary' : 'bg-secondary'
                        "
                        id="pills-datos-contacto-tab"
                        >2
                    </span>
                    Datos de contacto
                </li>
                <li class="nav-item" role="presentation">
                    <span
                        class="badge bg-primary rounded-pill"
                        :class="
                            paso == 3 ? 'active bg-primary' : 'bg-secondary'
                        "
                        id="pills-datos-empresa-tab"
                        >3
                    </span>
                    Datos empresa
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div
                    class="tab-pane fade"
                    :class="paso == 1 ? 'show active' : ''"
                    id="pills-correo"
                    role="tabpanel"
                >
                  Cancelar
                </button>
              </div>
              <div class="col-lg-6 text-end">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="
                    codigo_convenio = '';
                    verificar_codigo_convenio = false;
                    submit();
                  "
                >
                  Siguiente
                </button>
              </div>
            </div>
          </div>
          <div
            class="tab-pane fade"
            :class="paso == 2 ? 'show active' : ''"
            id="pills-datos-generales"
            role="tabpanel"
          >
            <div class="mb-3" v-if="convenio_id != ''">
              <label class="form-label">Código de convenio</label>
              <div class="input-group">
                <span class="input-group-text"
                  ><i class="fas fa-sort-numeric-down"></i>
                </span>
                <input
                  v-model="codigo_convenio"
                  type="text"
                  class="form-control"
                  @change="verificarCodigoConvenio()"
                />
              </div>
            </div>
            <div v-if="convenio_id == '' || verificar_codigo_convenio">
              <div class="mb-3">
                <label class="form-label required">Nombres</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-n"></i
                  ></span>
                  <input
                    v-model.trim="user.first_name"
                    type="text"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.user.first_name.$error,
                      'is-valid': !$v.user.first_name.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.first_name.required">{{
                      required
                    }}</span>
                  </div>
                </div>
                <div
                    class="tab-pane fade"
                    :class="paso == 2 ? 'show active' : ''"
                    id="pills-datos-contacto"
                    role="tabpanel"
                >
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-envelope"></i
                  ></span>
                  <input
                    v-model.trim="user.verify_email"
                    type="email"
                    class="form-control"
                    autocomplete="new-text"
                    :class="{
                      'is-invalid': $v.user.verify_email.$error,
                      'is-valid':
                        user.email != '' ? !$v.user.verify_email.$invalid : '',
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.verify_email.sameAsEmail">
                      El correo electrónico no coincide</span
                    >
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Cargo</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa fa-user"></i
                  ></span>

                            <div class="input-group">
                                <span class="input-group-text"
                                    ><i class="fa-solid fa-a"></i
                                ></span>
                                <input
                                    v-model.trim="user.last_name"
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': $v.user.last_name.$error,
                                        'is-valid': !$v.user.last_name.$invalid,
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span v-if="!$v.user.last_name.required">{{
                                        required
                                    }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Celular</label>
                            <div class="input-group">
                                <span class="input-group-text"
                                    ><i class="fa-solid fa-mobile"></i
                                ></span>
                                <input
                                    v-model.trim="user.phone"
                                    type="number"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': $v.user.phone.$error,
                                        'is-valid': !$v.user.phone.$invalid,
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span v-if="!$v.user.phone.required">{{
                                        required
                                    }}</span>
                                    <span
                                        v-if="
                                            !$v.user.phone.minLength ||
                                            !$v.user.phone.maxLength
                                        "
                                    >
                                        El número de celular debe contener 10
                                        dígitos</span
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Correo electrónico</label
                            >
                            <div class="input-group">
                                <span class="input-group-text"
                                    ><i class="fa-solid fa-envelope"></i
                                ></span>
                                <input
                                    type="email"
                                    class="form-control"
                                    :value="email"
                                    readonly
                                />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Cargo</label>
                            <div class="input-group">
                                <span class="input-group-text"
                                    ><i class="fa fa-user"></i
                                ></span>

                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-lock"></i
                  ></span>
                  <input
                    v-model.trim="user.password"
                    type="password"
                    id="contrasena"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.user.password.$error,
                      'is-valid': !$v.user.password.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.password.required">{{
                      required
                    }}</span>
                    <span v-if="!$v.user.password.minLength"
                      >Mínimo 8 caracteres</span
                    >
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Confirmar contraseña</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-lock"></i
                  ></span>
                  <input
                    v-model.trim="user.verify_password"
                    type="password"
                    id="verify_password"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.user.verify_password.$error,
                      'is-valid':
                        user.password != ''
                          ? !$v.user.verify_password.$invalid
                          : '',
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.user.verify_password.required">
                      La contraseña no coincide</span
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <button
                  @click="cancelar()"
                  type="button"
                  class="btn btn-danger"
                >
                    <div class="mb-3">
                        <label class="form-label required">Nit</label>
                        <input
                            v-model.trim="empresa.nit"
                            type="text"
                            class="form-control"
                            :disabled="nit != ''"
                            @change="verificarNitEmpresa()"
                            :class="{
                                'is-invalid': $v.empresa.nit.$error,
                                'is-valid': !$v.empresa.nit.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.nit.required">{{
                                required
                            }}</span>
                        </div>
                    </div>

                    <div v-if="mostrar_form_empresa">
                        <div class="mb-3">
                            <label class="form-label required">Empresa</label>
                            <input
                                v-model.trim="empresa.nombre"
                                type="text"
                                class="form-control"
                                :disabled="
                                    empresa_existe && empresa_existe_completa
                                "
                                :class="{
                                    'is-invalid': $v.empresa.nombre.$error,
                                    'is-valid': !$v.empresa.nombre.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.empresa.nombre.required">{{
                                    required
                                }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Código CIIU</label
                            >
                            <Multiselect
                                v-model.trim="empresa.codigo_ciiu_id"
                                :options="options_ciiu"
                                :searchable="true"
                                :disabled="
                                    empresa_existe && empresa_existe_completa
                                "
                                placeholder="Seleccione una opción"
                                valueProp="id"
                                label="nombre"
                                :class="{
                                    'is-invalid':
                                        $v.empresa.codigo_ciiu_id.$error,
                                    'is-valid':
                                        empresa.codigo_ciiu_id != ''
                                            ? !$v.empresa.codigo_ciiu_id
                                                  .$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span
                                    v-if="!$v.empresa.codigo_ciiu_id.required"
                                >
                                    {{ required }}</span
                                >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Sector</label>
                            <Multiselect
                                v-model.trim="empresa.sector_id"
                                :options="options_sector"
                                :searchable="true"
                                :disabled="
                                    empresa_existe && empresa_existe_completa
                                "
                                placeholder="Seleccione una opción"
                                valueProp="id"
                                label="nombre"
                                :class="{
                                    'is-invalid': $v.empresa.sector_id.$error,
                                    'is-valid':
                                        empresa.sector_id != ''
                                            ? !$v.empresa.sector_id.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.empresa.sector_id.required">
                                    {{ required }}</span
                                >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Empleados</label>
                            <Multiselect
                                v-model.trim="empresa.empleado_id"
                                :options="options_empleado"
                                :searchable="true"
                                :disabled="
                                    empresa_existe && empresa_existe_completa
                                "
                                placeholder="Seleccione una opción"
                                valueProp="id"
                                label="nombre"
                                :class="{
                                    'is-invalid': $v.empresa.empleado_id.$error,
                                    'is-valid':
                                        empresa.empleado_id != ''
                                            ? !$v.empresa.empleado_id.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.empresa.empleado_id.required">
                                    {{ required }}</span
                                >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Tamaño</label>
                            <Multiselect
                                v-model.trim="empresa.tamano_id"
                                :options="options_tamano"
                                :searchable="true"
                                :disabled="
                                    empresa_existe && empresa_existe_completa
                                "
                                placeholder="Seleccione una opción"
                                valueProp="id"
                                label="nombre"
                                :class="{
                                    'is-invalid': $v.empresa.tamano_id.$error,
                                    'is-valid':
                                        empresa.tamano_id != ''
                                            ? !$v.empresa.tamano_id.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.empresa.tamano_id.required">
                                    {{ required }}</span
                                >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Teléfono fijo o celular</label
                            >
                            <input
                                v-model.trim="empresa.telefono"
                                type="text"
                                class="form-control"
                                :disabled="
                                    empresa_existe && empresa_existe_completa
                                "
                                :class="{
                                    'is-invalid': $v.empresa.telefono.$error,
                                    'is-valid': !$v.empresa.telefono.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.empresa.telefono.required">{{
                                    required
                                }}</span>
                                <span v-if="!$v.empresa.telefono.minLength">
                                    El número de debe contener mínimo 7
                                    dígitos</span
                                >
                                <span v-if="!$v.empresa.telefono.maxLength">
                                    El número de debe contener máximo 10
                                    dígitos</span
                                >
                            </div>
                        </div>
                        <div class="mb-3" v-if="convenio_id == ''">
                            <label class="form-label required">Sede</label>
                            <Multiselect
                                v-model="id_sede"
                                :options="options_sede"
                                :searchable="true"
                                placeholder="Seleccione una opción"
                                valueProp="id"
                                label="nombre"
                                @input="getSedeById()"
                                :class="{
                                    'is-invalid': $v.id_sede.$error,
                                    'is-valid':
                                        id_sede != ''
                                            ? !$v.id_sede.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.id_sede.required">
                                    {{ required }}</span
                                >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Nombre sede</label
                            >
                            <input
                                v-model.trim="sede.nombre"
                                type="text"
                                class="form-control"
                                :disabled="id_sede != -1"
                                :class="{
                                    'is-invalid': $v.sede.nombre.$error,
                                    'is-valid': !$v.sede.nombre.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.sede.nombre.required">{{
                                    required
                                }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Departamento</label
                            >
                            <Multiselect
                                v-model.trim="sede.departamento_id"
                                :options="options_departamento"
                                placeholder="Seleccione una opción"
                                :searchable="true"
                                valueProp="id"
                                label="nombre"
                                @input="getOptionsCiudad()"
                                :disabled="id_sede != -1"
                                :class="{
                                    'is-invalid':
                                        $v.sede.departamento_id.$error,
                                    'is-valid':
                                        sede.departamento_id != ''
                                            ? !$v.sede.departamento_id.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.sede.departamento_id.required">
                                    {{ required }}</span
                                >
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Ciudad o municipio</label
                            >
                            <Multiselect
                                v-model.trim="sede.ciudad_id"
                                :options="options_ciudad"
                                placeholder="Seleccione una opción"
                                :searchable="true"
                                valueProp="id"
                                label="nombre"
                                :disabled="id_sede != -1"
                                :class="{
                                    'is-invalid': $v.sede.ciudad_id.$error,
                                    'is-valid':
                                        sede.ciudad_id != ''
                                            ? !$v.sede.ciudad_id.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.sede.ciudad_id.required">
                                    {{ required }}</span
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <button
                                @click="cancelar()"
                                type="button"
                                class="btn btn-danger"
                            >
                                Cancelar
                            </button>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="paso = 2"
                            >
                                Atrás
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="submit()"
                            >
                                Finalizar
                            </button>
                        </div>
                    </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Código CIIU</label>
                <Multiselect
                  v-model.trim="empresa.codigo_ciiu_id"
                  :options="options_ciiu"
                  :searchable="true"
                  :disabled="empresa_existe && empresa_existe_completa"
                  placeholder="Seleccione una opción"
                  valueProp="id"
                  label="nombre"
                  :class="{
                    'is-invalid': $v.empresa.codigo_ciiu_id.$error,
                    'is-valid':
                      empresa.codigo_ciiu_id != ''
                        ? !$v.empresa.codigo_ciiu_id.$invalid
                        : '',
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.empresa.codigo_ciiu_id.required">
                    {{ required }}</span
                  >
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Sector</label>
                <Multiselect
                  v-model.trim="empresa.sector_id"
                  :options="options_sector"
                  :searchable="true"
                  :disabled="empresa_existe && empresa_existe_completa"
                  placeholder="Seleccione una opción"
                  valueProp="id"
                  label="nombre"
                  :class="{
                    'is-invalid': $v.empresa.sector_id.$error,
                    'is-valid':
                      empresa.sector_id != ''
                        ? !$v.empresa.sector_id.$invalid
                        : '',
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.empresa.sector_id.required">
                    {{ required }}</span
                  >
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Empleados</label>
                <Multiselect
                  v-model.trim="empresa.empleado_id"
                  :options="options_empleado"
                  :searchable="true"
                  :disabled="empresa_existe && empresa_existe_completa"
                  placeholder="Seleccione una opción"
                  valueProp="id"
                  label="nombre"
                  :class="{
                    'is-invalid': $v.empresa.empleado_id.$error,
                    'is-valid':
                      empresa.empleado_id != ''
                        ? !$v.empresa.empleado_id.$invalid
                        : '',
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.empresa.empleado_id.required">
                    {{ required }}</span
                  >
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Tamaño</label>
                <Multiselect
                  v-model.trim="empresa.tamano_id"
                  :options="options_tamano"
                  :searchable="true"
                  :disabled="empresa_existe && empresa_existe_completa"
                  placeholder="Seleccione una opción"
                  valueProp="id"
                  label="nombre"
                  :class="{
                    'is-invalid': $v.empresa.tamano_id.$error,
                    'is-valid':
                      empresa.tamano_id != ''
                        ? !$v.empresa.tamano_id.$invalid
                        : '',
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.empresa.tamano_id.required">
                    {{ required }}</span
                  >
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Teléfono</label>
                <input
                  v-model.trim="empresa.telefono"
                  type="text"
                  class="form-control"
                  :disabled="empresa_existe && empresa_existe_completa"
                  :class="{
                    'is-invalid': $v.empresa.telefono.$error,
                    'is-valid': !$v.empresa.telefono.$invalid,
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.empresa.telefono.required">{{
                    required
                  }}</span>
                </div>
              </div>
              <div class="mb-3" v-if="convenio_id == ''">
                <label class="form-label required">Sede</label>
                <Multiselect
                  v-model="id_sede"
                  :options="options_sede"
                  :searchable="true"
                  placeholder="Seleccione una opción"
                  valueProp="id"
                  label="nombre"
                  @input="getSedeById()"
                  :class="{
                    'is-invalid': $v.id_sede.$error,
                    'is-valid': id_sede != '' ? !$v.id_sede.$invalid : '',
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.id_sede.required"> {{ required }}</span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Nombre sede</label>
                <input
                  v-model.trim="sede.nombre"
                  type="text"
                  class="form-control"
                  :disabled="id_sede != -1"
                  :class="{
                    'is-invalid': $v.sede.nombre.$error,
                    'is-valid': !$v.sede.nombre.$invalid,
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.sede.nombre.required">{{ required }}</span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Departamento</label>
                <Multiselect
                  v-model.trim="sede.departamento_id"
                  :options="options_departamento"
                  placeholder="Seleccione una opción"
                  :searchable="true"
                  valueProp="id"
                  label="nombre"
                  @input="getOptionsCiudad()"
                  :disabled="id_sede != -1"
                  :class="{
                    'is-invalid': $v.sede.departamento_id.$error,
                    'is-valid':
                      sede.departamento_id != ''
                        ? !$v.sede.departamento_id.$invalid
                        : '',
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.sede.departamento_id.required">
                    {{ required }}</span
                  >
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label required">Ciudad o municipio</label>
                <Multiselect
                  v-model.trim="sede.ciudad_id"
                  :options="options_ciudad"
                  placeholder="Seleccione una opción"
                  :searchable="true"
                  valueProp="id"
                  label="nombre"
                  :disabled="id_sede != -1"
                  :class="{
                    'is-invalid': $v.sede.ciudad_id.$error,
                    'is-valid':
                      sede.ciudad_id != '' ? !$v.sede.ciudad_id.$invalid : '',
                  }"
                />
                <div class="invalid-feedback">
                  <span v-if="!$v.sede.ciudad_id.required">
                    {{ required }}</span
                  >
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <button
                  @click="cancelar()"
                  type="button"
                  class="btn btn-danger"
                >
                  Cancelar
                </button>
              </div>
              <div class="col-lg-6 text-end">
                <button
                  type="button"
                  class="btn btn-secondary"
                  @click="paso = 2"
                >
                  Atrás
                </button>
                <button type="button" class="btn btn-primary" @click="submit()">
                  Finalizar
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
import {
    required,
    email,
    sameAs,
    minLength,
    maxLength,
} from "vuelidate/lib/validators";
import User from "../../models/User";
import Empresa from "../../models/Empresa";
import EmpresaSede from "../../models/EmpresaSede";
import Parametro from "../../models/Parametro";
import Convenio from "../../models/Convenio";
import ConvenioEmail from "../../models/ConvenioEmail";

export default {
  components: {
    NavbarComponent
  },
  data() {
    return {
      user: new User({
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        verify_email: "",
        password: "",
        verify_password: "",
        cargo: "",
        estado: "",
        rol_id: "",
        empresa_id: "",
        sede_id: "",
      }),

      empresa: new Empresa({
        id: "",
        nombre: "",
        nit: "",
        telefono: "",
        codigo_ciiu_id: "",
        sector_id: "",
        empleado_id: "",
        tamano_id: "",
        departamento_id: "",
        ciudad_id: "",
        usuario_actualizo_id: "",
      }),

      sede: new EmpresaSede({
        id: "",
        nombre: "",
        empresa_id: "",
        departamento_id: "",
        ciudad_id: "",
      }),

      id_sede: "",

      empresa_existe: false,
      empresa_existe_completa: false,

      email: "",
      verify_email: "",
      verificar_codigo_convenio: false,
      mostrar_form_empresa: false,
      codigo_convenio: "",
      sede_id_empresario: "",
      nit: "",
      paso: 1,
      required: "Este campo es requerido",
      convenio_id: null,
      options_departamento: [],
      options_ciudad: [],
      options_sector: [],
      options_ciiu: [],
      options_tamano: [],
      options_empleado: [],
      options_sede: [],
    };
  },
  validations: {
    user: {
      first_name: {
        required,
      },
      last_name: {
        required,
      },
      phone: {
        required,
      },
      email: {
        required,
      },
      verify_email: {
        sameAsEmail: sameAs("email"),
      },
      cargo: {
        required,
      },
      password: {
        required,
        minLength: minLength(8),
      },
      verify_password: {
        required,
        sameAsPassword: sameAs("password"),
      },
    },
    validations: {
        user: {
            first_name: {
                required,
            },
            last_name: {
                required,
            },
            phone: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(10),
            },
            email: {
                required,
            },
            cargo: {
                required,
            },
            password: {
                required,
                minLength: minLength(8),
            },
            verify_password: {
                required,
                sameAsPassword: sameAs("password"),
            },
        },
        empresa: {
            nit: {
                required,
            },
            nombre: {
                required,
            },
            tamano_id: {
                required,
            },
            empleado_id: {
                required,
            },
            sector_id: {
                required,
            },
            codigo_ciiu_id: {
                required,
            },
            telefono: {
                required,
                minLength: minLength(7),
                maxLength: maxLength(10),
            },
        },
        sede: {
            nombre: {
                required,
            },
            departamento_id: {
                required,
            },
            ciudad_id: {
                required,
            },
        },
        id_sede: {
            required,
        },
        email: {
            required,
            email,
        },
        verify_email: {
            sameAsEmail: sameAs("email"),
        },
    },
    sede: {
      nombre: {
        required,
      },
      departamento_id: {
        required,
      },
      ciudad_id: {
        required,
      },
    },
    id_sede: {
      required,
    },
    email: {
      required,
      email,
    },
    verify_email: {
      sameAsEmail: sameAs("email"),
    },
  },
  mounted() {
    this.getParametros(1, "options_departamento");
    this.getParametros(3, "options_sector");
    this.getParametros(4, "options_ciiu");
    this.getParametros(5, "options_tamano");
    this.getParametros(6, "options_empleado");
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

    async getOptionsCiudad() {
      this.options_ciudad = [];
      if (
        this.sede.departamento_id != "" &&
        this.sede.departamento_id != null
      ) {
        this.sede.ciudad_id = "";

        this.options_ciudad = await Parametro.where(
          "parametro_id",
          this.sede.departamento_id
        ).get();
      }
    },
    async submit() {
      this.$v.$touch();
      if (this.paso == 1) {
        if (!(this.$v.email.$invalid || this.$v.verify_email.$invalid)) {
          let check_email = await User.where("email", this.email).get();

                    if (check_email.length != 0) {
                        Swal.fire({
                            title: "Alerta",
                            html: "El correo electrónico ingresado ya se encuentra registrado en el sistema, por favor ingrese con el usuario y contraseña previamente creados",
                            icon: "warning",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonColor: "#3085d6",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.$root.redirectIndex("login");
                            }
                        });
                    } else {
                        this.paso = 2;
                        this.$v.$reset();
                        this.$v.user.$reset();
                        this.verificarEmailConvenio();
                        this.form = {};
                        this.user.email = this.email;
                    }
                }
            }
            if (this.paso == 2) {
                if (!this.$v.user.$invalid) {
                    this.$v.$reset();
                    this.paso = 3;
                    this.mostrar_form_empresa = false;
                    this.limpiarFormEmpresa();
                    if (this.nit != "") {
                        this.empresa.nit = this.nit;
                        this.verificarNitEmpresa();
                    }
                }
            }
            if (this.paso == 3) {
                if (!this.$v.$invalid) {
                    //Empresa
                    if (!this.empresa_existe) {
                        delete this.empresa["id"];
                    }
                    var empresa_creada = await this.empresa.save();

          //Sede
          var empresa_sede = "";
          if (this.id_sede == -1) {
            delete this.sede["id"];
            this.sede.empresa_id = empresa_creada.id;
            empresa_sede = await this.sede.save();
          } else {
            empresa_sede = this.sede;
          }

          //Usuario
          this.user.rol_id = 2;
          this.user.estado = this.convenio_id == "" ? 0 : 1;
          this.user.empresa_id = empresa_creada.id;
          this.user.sede_id = empresa_sede.id;

          await this.user.save();

          if (this.convenio_id == "") {
            this.$root.mostrarMensaje(
              "Éxito",
              "Usuario creado sin convenio, a la espera de revisión de pago",
              "success"
            );
          } else {
            this.$root.mostrarMensaje(
              "Éxito",
              "Usuario creado por convenio",
              "success"
            );
          }
          setTimeout(() => {
            this.cancelar();
          }, 2000);
        }
      }
    },
    async verificarNitEmpresa() {
      this.id_sede = null;
      this.limpiarFormSede();

      this.options_sede = [{ id: -1, nombre: "Nueva sede" }];

      let empresa = await Empresa.where("nit", this.empresa.nit)
        .include("convenios", "sedes")
        .get();

      if (this.convenio_id != "") {
        if (this.nit != this.empresa.nit) {
          this.$root.mostrarMensaje(
            "Error",
            "Este NIT no se encuentra vinculado al convenio y correo ingresado.",
            "error"
          );
          Object.keys(this.empresa).forEach((key) => {
            if (key != "nit") {
              this.empresa[key] = "";
            }
          });
          this.mostrar_form_empresa = false;
          return false;
        } else {
          this.cargarInfoEmpresa(empresa);
        }
      } else {
        if (empresa.length != 0) {
          if (empresa[0].convenios.length != 0) {
            this.$root.mostrarMensaje(
              "Error",
              "El nit diligenciado se encuentra registrado a un convenio, no se puede utilizar para un registro individual, por favor cambielo",
              "error"
            );
            this.mostrar_form_empresa = false;
            return false;
          } else {
            this.cargarInfoEmpresa(empresa);
          }
        } else {
          this.cargarInfoEmpresa(empresa);
        }
      }
    },

    cargarInfoEmpresa(empresa) {
      this.mostrar_form_empresa = true;

      if (empresa.length != 0) {
        this.empresa = empresa[0];
        empresa[0].sedes.forEach((e) => {
          this.options_sede.push(e);
        });

        this.id_sede = this.sede_id_empresario;
        this.getSedeById();
        this.empresa_existe_completa =
          this.empresa.nombre == null ? false : true;
        this.empresa_existe = true;
      } else {
        Object.keys(this.empresa).forEach((key) => {
          if (key != "nit") {
            this.empresa[key] = "";
          }
        });
        this.empresa_existe = false;
      }
    },

    async getSedeById() {
      this.limpiarFormSede();

      if (this.id_sede != -1 && this.id_sede != null) {
        let sede = await EmpresaSede.include("empresa").find(this.id_sede);
        this.sede.id = sede.id;
        this.sede.nombre = sede.nombre;
        this.sede.empresa_id = sede.empresa_id;
        this.sede.departamento_id = sede.departamento_id;
        this.getOptionsCiudad();
        this.sede.ciudad_id = sede.ciudad_id;
      }
    },

    async verificarEmailConvenio() {
      let convenio_email = await ConvenioEmail.where("email", this.email)
        .get()
        .catch((error) => {
          this.$root.mostrarMensaje(
            "error",
            "No se pudo verificar el convenio, por favor intentelo de nuevo",
            "error"
          );
        });

      this.convenio_id =
        convenio_email.length == 0 ? "" : convenio_email[0].convenio_id;
      this.nit = convenio_email.length == 0 ? "" : convenio_email[0].nit;
      this.sede_id_empresario =
        convenio_email.length == 0 ? "" : convenio_email[0].sede_id;
    },
    async verificarCodigoConvenio() {
      this.limpiarFormUser();

            let convenio_email = await ConvenioEmail.include("convenio")
                .where({
                    email: this.email,
                    "convenio.codigo": this.codigo_convenio,
                })
                .get();

      if (convenio_email.length != 0) {
        this.verificar_codigo_convenio = true;
      } else {
        this.verificar_codigo_convenio = false;
        this.$root.mostrarMensaje(
          "Atención",
          "El correo electrónico o el código de convenio no se encuentran registrados en el sistema, por favor verifique que la información esté correcta o contacte al administrador",
          "warning"
        );
      }
    },
    limpiarFormUser() {
      Object.keys(this.user).forEach((key) => {
        if (key != "email") {
          this.user[key] = "";
        }
      });
    },
    limpiarFormEmpresa() {
      Object.keys(this.empresa).forEach((key) => {
        this.empresa[key] = "";
      });
    },
    limpiarFormSede() {
      Object.keys(this.sede).forEach((key) => {
        this.sede[key] = "";
      });
    },
    cancelar() {
      window.location.href = "login";
    },
  },
};
</script>
<style>
.required:after {
  content: " *";
  color: red;
}
.nav-link.active {
  color: #000 !important;
  background-color: white !important;
}
.nav-link:hover,
.nav-link:focus {
  color: #000;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
