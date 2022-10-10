<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<form method="post" action="{{url('get-gif')}}">
    @csrf
    <div class="card" style="width:100%">
        <div class="card-body">
            <h1 class="card-title">Video to GIF converter</h1>
            <div id="video-player">
                <video id="convert_video" width="320" height="240" controls>
                    <source src="{{asset($videoPath)}}" type="video/mp4">
                </video>
            </div>
{{--            <p class="filestats">File size: <strong>719.62KiB</strong>, width: 1152px, height: 720px, type: mp4 (video), length: 00:00:42 <span class="convert-wrap">--}}
{{--			<span class="convert-btn button">convert <img src="https://ezgif.com/images/fugue-icons/navigation-270-button-white.png" alt="" width="16" height="16"></span>--}}
{{--			<span class="convert-options" style="display:none"><a href="/video-to-gif/ezgif-3-340cc7cf66.mp4">to GIF</a><a href="/video-to-apng/ezgif-3-340cc7cf66.mp4">to APNG</a><a href="/video-to-webp/ezgif-3-340cc7cf66.mp4">to WebP</a><a href="/video-to-mng/ezgif-3-340cc7cf66.mp4">to MNG</a><a href="/video-to-flif/ezgif-3-340cc7cf66.mp4">to FLIF</a><a href="/video-to-avif/ezgif-3-340cc7cf66.mp4">to AVIF</a><a href="/video-to-jpg/ezgif-3-340cc7cf66.mp4">to JPG</a><a href="/video-to-mp4/ezgif-3-340cc7cf66.mp4">to MP4</a></span>--}}
		</span></p>
            <br>
            <div class="form-control">
                <label for="start">Start time (seconds): </label>
                <input type="text" name="startTime" id="startTime" value="0">&nbsp&nbsp<input class="btn btn-primary" style="padding: 1.5px 10px;" type="button" id="read_pos_start" value="Use current position">
                <br>
                <br>
                <label for="start">End time (seconds): </label>&nbsp&nbsp
                <input type="text" name="endTime" id="endTime" value="5">&nbsp&nbsp<input class="btn btn-primary" style="padding: 1.5px 10px;" type="button" id="read_pos_end" value="Use current position">
                <br>
                <br>
                <div class="form-control">
{{--                    <select name="size" id="size">--}}
{{--                        <option value="original" selected="selected">Original</option>--}}
{{--                        <option value="960">Widescreen: 960 x 540</option>--}}
{{--                        <option value="720">Square: 720×720</option>--}}
{{--                        <option value="720x960">Tall: 720×960</option>--}}
{{--                        <option value="500">500xAUTO</option>--}}
{{--                        <option value="480">480xAUTO</option>--}}
{{--                        <option value="400">400xAUTO</option>--}}
{{--                        <option value="320">320xAUTO</option>--}}
{{--                        <option value="480p">AUTOx480</option>--}}
{{--                        <option value="320p">AUTOx320</option>--}}
{{--                        <option value="1200w">up to 1200x300 (for wide banner)</option>--}}
{{--                        <option value="1200h">up to 300x1200 (for skyscraper banner)</option>--}}
{{--                    </select>--}}

                    <select name="size" id="size">
                        <option value="original" selected="selected">Original</option>
                        <option value="600">600xAUTO</option>
                        <option value="540">540xAUTO (for Tumblr)</option>
                        <option value="500">500xAUTO</option>
                        <option value="480">480xAUTO</option>
                        <option value="400">400xAUTO</option>
                        <option value="320">320xAUTO</option>
                        <option value="480p">AUTOx480</option>
                        <option value="320p">AUTOx320</option>
                        <option value="1200w">up to 1200x300 (for wide banner)</option>
                        <option value="1200h">up to 300x1200 (for skyscraper banner)</option>
                    </select>
                </div>
                <br>
                <button class="btn btn-success">Convert to Gif</button>
            </div>
        </div>

        <div class="card-body">

        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){

        //get current time in second
        var vid = document.getElementById("convert_video");

        //for read Start Time
        $('#read_pos_start').on('click',function(){
              $('#startTime').val($('#startTime').val() + vid.currentTime) ;
              $('#startTime').val('');
              $('#startTime').val($('#startTime').val() + vid.currentTime);
        });

        //for read End Time
        $('#read_pos_end').on('click',function(){
            $('#endTime').val($('#endTime').val() + vid.currentTime) ;
            $('#endTime').val('');
            $('#endTime').val($('#endTime').val() + vid.currentTime);
        });
    });
</script>
