<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Video tutoriales</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 offset-lg-1">
                        <label>Video tutorial - Ingresar datos</label>
                        <video width="500" height="240" controls="controls">
                            <source
                                :src="
                                    require('../../img/Video_tutorial_-_Ingresar_datos.mp4')
                                "
                                type="video/mp4"
                            />
                        </video>
                    </div>
                    <div class="col-lg-5">
                        <label>Video tutorial - Consultar resultados</label>
                        <video height="240" controls="controls">
                            <source
                                :src="
                                    require('../../img/Video_tutorial_-_Consultar_resultados.mp4')
                                "
                                type="video/mp4"
                            />
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
video {
    width: 100%;
}
</style>
