<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class ImageHandleController extends Controller
{
    public function imageLogo()
    {
        return view('image-view');
    }

    public function addLogoImage(Request $request)
    {
        $ffmpeg = \FFMpeg\FFMpeg::create();

        $videoPath = public_path('videos/export-webm.webm');
        $logoPath = public_path('images/1.png');
        $video = $ffmpeg->open($videoPath);
        $video
            ->filters()
            ->watermark($logoPath, array(
                'position' => 'absolute',
                'x' => 10,
                'y' => 10,
            ));
        $video->save(new \FFMpeg\Format\Video\X264(), 'output.mp4');

        return response()->json('successfully created');

    }

    public function pngOnPng(Request $request)
    {
        $img = Image::make(public_path('images/test.png'), 'top-left', 1118, 1298);

        $x = (int)294.999999;
        $y = 216;

        /* resize image before insert image */
        $imgFile1 = Image::make(public_path('images/1.png'));
        $imgFile2 = Image::make(public_path('images/2.png'));
        $imgFile3 = Image::make(public_path('images/3.png'));

        $imageWidth = 100;
        $imageHeight = 100;

        $imgFile1->resize($imageWidth, $imageHeight, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imgFile2->resize($imageWidth, $imageHeight, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imgFile3->resize($imageWidth, $imageHeight, function ($constraint) {
            $constraint->aspectRatio();
        });

        /* insert watermark at top-left corner with 110px offset */
        $img->insert($imgFile1, 'top-left', $x, $y);
        $img->insert($imgFile2, 'top-left', 646, 574);
        $img->insert($imgFile3, 'top-left', 346, 574);

        $var = Carbon::now('Asia/Kolkata');
        $time = 'Image' . $var->toTimeString();

        $name = $time . '.png';

        $img->save(public_path('ConvertImages/') . $name);

        return response()->json('image successfully created');

    }

}
