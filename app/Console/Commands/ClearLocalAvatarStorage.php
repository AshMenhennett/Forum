<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLocalAvatarStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:avatars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear local avatar storage. The local avatars are uploaded to s3, once uploaded, it is fine to delete them.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = glob(storage_path() . '/avatars/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        $this->info('Local avatars have been cleared');
    }
}
