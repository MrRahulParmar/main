{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <title>Document</title>--}}

{{--    <!-- Bootstrap CSS -->--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"--}}
{{--          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="container">--}}
{{--    <div class="row">--}}

{{--        <!-- creating the form -->--}}
{{--        <!-- apply encoding type to process file -->--}}
{{--        <form method="POST" action="{{url('upload-image-display')}}" enctype="multipart/form-data">--}}
{{--    @csrf--}}
{{--            <!-- creating video input file -->--}}
{{--            <div class="form-group">--}}
{{--                <label>Select video</label>--}}
{{--                <input type="file" name="rowImage" class="form-control">--}}
{{--            </div>--}}

{{--            <!-- creating image input file -->--}}
{{--            <div class="form-group">--}}
{{--                <label>Select image</label>--}}
{{--                <input type="file" name="logoImage" class="form-control">--}}
{{--            </div>--}}

{{--            <!-- create submit button -->--}}
{{--            <input type="submit" class="btn btn-primary" value="Add overlay">--}}

{{--        </form>--}}
{{--    </div>--}}

{{--</div>--}}
{{--</body>--}}
{{--</html>--}}

<html>
<head>
    <title>X, Y Coordinates using jQuery</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body>
<div style="width:300px;">
    <h4>X & Y Coordinates</h4>
    <div><img src="{{url('/images/test.png')}}" alt="" height="90%" width="120%" /></div>
    <div style="padding-top:20px;">
        <div id="coord"></div>
    </div>
</div>
</body>
<script>
    $(document).ready(function() {
        $('img').click(function(e) {
            var offset = $(this).offset();
            var X = (e.pageX - offset.left);
            var Y = (e.pageY - offset.top);
            $('#coord').text('X: ' + X + ', Y: ' + Y);
        });
    });
</script>
</html>
