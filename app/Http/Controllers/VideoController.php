<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Exception;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;


class VideoController extends Controller
{
    public function getGif(Request $request)
    {
        $path = Video::select('path')->idDescending()->first();
        $videoName = public_path() . '/videos/' . $path;

        $videoPath = str_replace(array('{"path":"', '"}'), '', $videoName);

        // The gif duration will be as long as the video/
        $ffprobe = FFProbe::create();
        $startDuration = $request->startTime;
        $endDuration = $request->endTime;

        if ($startDuration > $endDuration) {
            $endDuration = 5;
        }

        //for Http Request Video to gif Convert
        if (strpos($path->path, "http") === 0) {

            // The gif duration will be as long as the video/
            $ffprobe = FFProbe::create();
            $startDuration = $request->startTime;
            $endDuration = $request->endTime;

            if ($startDuration > $endDuration) {
                $endDuration = 5;
            }

            //$gifname = uniqid('GIF_Http_') . '.gif';
            $gifname = 'GIF' . '_' . 'Http' . '_' . date('Y-m-d-H:i:s') . '.gif';
            $filePath = public_path() . '/gif/' . $gifname;

            $dimensions = $ffprobe->streams($path->path)->videos()->first()->getDimensions();

            $ffmpeg = FFMpeg::create();
            $ffmpegVideo = $ffmpeg->open($path->path);

            $ffmpegVideo->gif(TimeCode::fromSeconds($startDuration), $dimensions, $endDuration)->save($filePath);

            return redirect('/')->with('success', 'Successfully video to gif converted');
        }

        // The gif will have the same dimension. You can change that of course if needed.
        $dimension = $ffprobe->streams($videoPath)->videos()->first()->getDimensions();
        $dimensionWidth = $ffprobe->streams($videoPath)->videos()->first()->getDimensions()->getWidth();
        $dimensionHeight = $ffprobe->streams($videoPath)->videos()->first()->getDimensions()->getHeight();

        //fore custom Dimensions for video
        $videoSize = $request->size;

        if ($videoSize == 'original') {
            $width = $dimensionWidth;
            $height = $dimensionHeight;
        } elseif ($videoSize == '540') {
            $width = 540;
            $height = $dimensionHeight;
        } elseif ($videoSize == '500') {
            $width = 500;
            $height = $dimensionHeight;
        } elseif ($videoSize == '480') {
            $width = 480;
            $height = $dimensionHeight;
        } elseif ($videoSize == '480') {
            $width = 400;
            $height = $dimensionHeight;
        } elseif ($videoSize == '320') {
            $width = 320;
            $height = $dimensionHeight;
        } elseif ($videoSize == '480p') {
            $width = $dimensionWidth;
            $height = 480;
        } elseif ($videoSize == '320p') {
            $width = $dimensionWidth;
            $height = 320;
        } elseif ($videoSize == '1200w') {
            $width = 1200;
            $height = 300;
        } elseif ($videoSize == '1200h') {
            $width = 300;
            $height = 1200;
        }


        $customDimension = new \FFMpeg\Coordinate\Dimension($width, $height);
//        dd($customDimension);
        //$gifname = uniqid('GIF_') . '.gif';
        $gifname = 'GIF' . '_' . date('Y-m-d-H:i:s') . '.gif';
        $filePath = public_path() . '/gif/' . $gifname;

        // Transform
        $ffmpeg = FFMpeg::create();
        $ffmpegVideo = $ffmpeg->open($videoPath);
        //$ffmpegVideo->gif(TimeCode::fromSeconds($startDuration), $dimensions, $endDuration)->save($filePath);
        $ffmpegVideo->gif(TimeCode::fromSeconds($startDuration), isset($width, $height) ? $customDimension : $dimension, $endDuration)->save($filePath);


        if (!$ffmpegVideo) {
            return redirect('/')->with('error', 'Something went to wrong');
        }

        return redirect('/')->with('success', 'Successfully video to gif converted');

    }

    public function getVideoUploadForm(Request $request)
    {
        return view('video-upload');
    }

    public function uploadVideo(Request $request)
    {
        //this code for chunk video upload
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if ($receiver == "") {
            return redirect('video-upload')->with('error', 'please upload video');
        }

        if ($request->newImageUrl == true) {
            $videoUrl = new Video();
            $videoUrl->title = 'GIF' . '_' . date('Y-m-d-H:i:s') . '.gif';
            $videoUrl->path = $request->newImageUrl;
            $videoUrl->save();

            return redirect('view-upload-video')->with('success', 'Video has been successfully uploaded.');

        }

        if (!$receiver->isUploaded()) {
            throw new Exception("Video Does not Upload");
        }

        $fileReceived = $receiver->receive(); // receive file

        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '.' . $extension; // a unique file name

            $filePath = 'videos';
            $path = $file->move(public_path($filePath), $fileName);
            if ($path) {
                $video = new Video();
                $video->title = 'GIF' . '_' . date('Y-m-d') . '.gif';
                $video->path = $fileName;
                $video->save();
            }

//            // delete chunked file
//            unlink($file->getPathname());
            return [
                'path' => asset('storage/' . $path),
                'filename' => $fileName
            ];

        }

        //this code for original video upload
//        $this->validate($request, [
//            'title' => 'required|string|max:255',
//            'video' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts,qt|max:50000',
//        ]);
//
//        if ($request->newImageUrl == true){
//            $videoUrl = new Video();
//            $videoUrl->title = $request->title;
//            $videoUrl->path = $request->newImageUrl;
//            $videoUrl->save();
//
//            return redirect('view-upload-video')->with('success', 'Video has been successfully uploaded.');
//
//        }
//
//        $fileName = $request->video->getClientOriginalName();
//        $filePath = 'videos';
//
//
//        $isFileUploaded = $request->video->move(public_path($filePath), $fileName);
//
//        // File URL to access the video in frontend
//        $url = Storage::disk('public')->url($filePath);
//
//        if ($isFileUploaded) {
//            $video = new Video();
//            $video->title = $request->title;
//            $video->path = $fileName;
//            $video->save();
//
//            return redirect('view-upload-video')->with('success', 'Video has been successfully uploaded.');
//
//        }
//
//        return back()
//            ->with('error', 'Unexpected error occured');

    }

    public function display()
    {
        //for demo purposes we'll access the first file
        $path = Video::select('path')->idDescending()->first();

        if (strpos($path->path, "http") === 0) {
            $videoPath = $path->path;
            return view('upload-display')->with('videoPath', $videoPath);
        }

        $filePath = public_path() . '/videos/' . $path;


        $trimBracketPath = str_replace(array('{"path":"', '"}'), '', $filePath);
        $videoPath = str_replace(array('/opt/lampp/htdocs/project/VideoToGif/public'), '', $trimBracketPath);

        return view('upload-display')->with('videoPath', $videoPath);
    }


}
