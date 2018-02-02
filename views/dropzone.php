<div id="<?= $id ?>" class="well x1-dropzone dropzone">
    <h1 class="text-center"><i class="fa fa-cloud-upload"></i></h1>


    <p class="actions" style="display: none">

        <span class="btn btn-success fileinput-button dz-clickable">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Add files...</span>
        </span>
        <button type="submit" class="btn btn-primary start">
            <i class="glyphicon glyphicon-upload"></i>
            <span>Start upload</span>
        </button>
        <button type="reset" class="btn btn-warning cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel upload</span>
        </button>

    </p>


    <p>
        <span class="fileupload-process">
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
            </div>
        </span>
    </p>


    <div class="previews">
    </div>


</div>