<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class TempFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp_file:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $current_time = date('Y-m-d H:i:s', strtotime(Carbon::now()->addMinute(-1)));
        $temp_files = \App\Models\TempFile::where('created_at', '<', $current_time)->get();
        foreach ($temp_files as $temp_file){
            if (file_exists(public_path('backend/upload/video/all/'.$temp_file->name))){
                unlink(public_path('backend/upload/video/all/'.$temp_file->name));
            }
            $temp_file->delete();
        }
    }
}
