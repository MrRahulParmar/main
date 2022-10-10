<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>video to gif</title>
</head>
<style>
    .card-footer, .progress {
        display: none;
    }
</style>
<body>

<!-- Form for Video Upload -->
<div class="form-1-container section-container">
    <div class="container">
        <div class="row">
            <div class="col form-1 section-description wow fadeIn">
                <h2>Laravel Video Upload For Gif Convert</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1 form-1-box wow fadeInUp">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('store.video') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- User's Credentials  -->
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2">Upload video file</legend>
{{--                        <div class="form-group">--}}
{{--                            <label for="username">Title:</label>--}}
{{--                            <input type="text" name="title" id="title" class="form-control"/>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="email">Select Video:</label>
                            <input type="file" id="browseFile" name="video" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Or paste video URL:</label>
                            <input type="text" name="newImageUrl" id="httpAddress" class="form-control" placeholder="https://"/>
                        </div>
                    </fieldset>

                    <!--Progress Bar for Uploading Video-->
                    <div class="card-body">
                        <div class="progress mt-3" style="height: 25px">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                 style="width: 75%; height: 100%">75%
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-4" >
                        <video id="videoPreview" src="" controls style="width: 100%; height: auto"></video>
                    </div>
                    <!-- Submit Button  -->
                    <div class="form-group row text-right">
                        <div class="col">
                            <button type="submit"  class="btn btn-primary btn-customized click-btn-down"><i
                                    class="fa-thin fa-cloud-arrow-up">Upload Http videos!</i></button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Resumable JS -->
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" ></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->

<script type="text/javascript">

    let browseFile = $('#browseFile');
    let resumable = new Resumable({
        target: '{{ route('store.video') }}',
        query:{_token:'{{ csrf_token() }}'} ,// CSRF token
        fileType: ['mp4','mpeg','ogg','webm','3gp','mov','flv','avi','wmv','ts'],
        headers: {
            'Accept' : 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function (file) { // trigger when file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
        window.location.href="{{route('view.video')}}";
    });

    resumable.on('fileError', function (file, response) { // trigger when there is any error
        alert('file uploading error.')
    });


    let progress = $('.progress');
    function showProgress() {
        progress.find('.progress-bar').css('width', '0%');
        progress.find('.progress-bar').html('0%');
        progress.find('.progress-bar').removeClass('bg-success');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.progress-bar').css('width', `${value}%`)
        progress.find('.progress-bar').html(`${value}%`)
    }

    function hideProgress() {
        progress.hide();
    }
</script>

</body>
</html>
