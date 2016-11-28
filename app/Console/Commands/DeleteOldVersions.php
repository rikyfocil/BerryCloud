<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Auth;
use App\File;

class DeleteOldVersions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:DeleteOld';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete versions older than a year';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //We must be logged in with root account to execute the function.
        Auth::loginUsingId(1);
        \Log::info('Cleanning script running.');
        //We get all info form table files
        $files = File::all();
        //Getting the local time with carbon
        $now = strtotime(Carbon::now());

        /*
        We'll check for every single file if it was created since more than a year, then we check every versions
        of that file with the same step, check if the version was created since more than a year. If the answer is yes,
        we proceed to delete the version.
        */
        foreach ($files as $file) {
            $id = $file->id;
            $fileAge = $now - strtotime($file->created_at);

            if ($file->isFolder) {
                continue;
            }

            if ($fileAge > 31536000) { //Check for one year old
                $versions = $file->versions()->get();
                $file->versions = $versions;
                $currentVersion = $file->versions()->orderBy('updated_at', 'desc')->first();

                foreach ($file->versions as $v) {
                    $versionAge = $now - strtotime($v->updated_at);
                    if ($v->id != $currentVersion->id) {
                        if ($versionAge > 31536000) {
                            if (!$version->delete()) {
                                Log::critical('Could not delete version '.$version->id);
                                abort(500);
                            }
                        }
                    }
                }
            }
        }
    }
}
