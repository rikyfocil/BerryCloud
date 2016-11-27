<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Auth;

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
        $files = DB::table('files')->get();
        //Getting the local time with carbon
        $now = strtotime(Carbon::now());

        /*
        We'll check for every single file if it was created since more than a year, then we check every versions
        of that file with the same step, check if the version was created since more than a year. If the answer is yes,
        we proceed to delete the version.
        */
        foreach ($files as &$file) {
            $id = $file->id;
            $file1 = \App\File::where('id', $id)->firstOrFail();
            $fileAge = $now - strtotime($file1->created_at);

            if ($fileAge > /*31536000*/ 100) { //Check for one year = 31536000
                $versions = DB::table('versions')->where('idFile', '=', $file1->id)->get();
                $file->versions = $versions;
                $currentFile = DB::table('versions')->orderBy('updated_at','desc')->where('idFile', '=', $file1->id)->first();

                foreach ($file->versions as &$v) {
                    $version = \App\Version::where('id', $v->id)->firstOrFail();
                    $versionAge = $now - strtotime($v->created_at);
                    if($v->updated_at != $currentFile->updated_at){
                        if ($versionAge > /*31536000*/ 100) {
                            // Now we validate that there is at least 2 versions
                        if ($file1->versions()->count() > 1) {
                            // As usual, we cross check the version with the file
                            if ($file->id != $version->file()->first()->id) {
                                abort(404);
                            }

                            if (!$version->delete()) {
                                Log::alert('Could not delete version '.$version->id);
                                abort(500);
                            }
                            $version->delete();
                        }
                        }
                    }
                }
            }
        }
    }
}
