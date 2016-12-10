<?php

namespace App\Jobs;

use File;
use Image;
use Storage;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadAvatar implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $fileId;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $fileId)
    {
        $this->user = $user;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // uploads a user's avatar to S3
        $path = storage_path() . '/avatars/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        Image::make($path)->encode('png')->fit(100, 100, function ($constraint) {
            $constraint->upsize();
        });

        Storage::disk('s3')->put('avatars/'. $fileName, fopen($path, 'r+'));
        //File::delete($path); -- not working

        $this->user->avatar = $fileName;
        $this->user->save();

    }
}
