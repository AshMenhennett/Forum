<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
class ClearCompiledViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:views';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear compiled views in framework/views/*';
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
        /**
        * Get all compiled views in storage/framework/views and delete (unlink) them.
        *
        * Vue reuses compiled components. Not helpful when developing, so let's clear those files,
        * to use latest version of Vue component.
        *
        * Run this command after making changes to Vue components, then run gulp. i.e. comp:views && gulp
        *
        * Remember: Register this command in App\Console\Kernel.
        * You can do this by adding this command's fully qualified class name to the commands array in App\Console\Kernel.
        */
        $files = glob(storage_path() . '/framework/views/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        $this->info('Compiled views have been cleared');
    }
}
