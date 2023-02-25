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
                    <div class="col-lg-4 offset-lg-2">
                        <label>Video 1</label>
                        <video height="240" controls="controls">
                            <source
                                src="http://media.w3.org/2010/05/sintel/trailer.mp4"
                                type="video/mp4"
                            />
                        </video>
                    </div>
                    <div class="col-lg-4">
                        <label>Video 2</label>
                        <video width="320" height="240" controls="controls">
                            <source
                                src="http://media.w3.org/2010/05/sintel/trailer.mp4"
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
