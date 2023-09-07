<?php

namespace App\Jobs;

use App\Models\Movie;
use App\Models\TempFile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MovieAdd implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $movie;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($movie)
    {
        $this->movie = $movie;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $video = $this->movie;
        $temp_file = TempFile::findOrFail($video->video_url);
        $temp_video = public_path('backend/upload/video/all/'.$temp_file->name);
        $upload_video_cloudinary = Cloudinary::uploadVideo($temp_video);
        if ($upload_video_cloudinary == true){
            if (file_exists(public_path('backend/upload/video/all/'.$temp_file->name))){
                unlink(public_path('backend/upload/video/all/'.$temp_file->name));
            }
        }
        $temp_file->delete();
        $video->video_url = $upload_video_cloudinary->getSecurePath();
        $video->video_public_id = $upload_video_cloudinary->getPublicId();
        $video->video_status = 'Complete';
        $video->save();
    }
}
