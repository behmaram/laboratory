<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Turn;

class RunTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        $turnObj = new Turn();
        $messageObj = new MessageClass();
        $userObj = new User();
        $allTestsTimeTorun =$turnObj->doingTest();
        foreach ($allTestsTimeTorun as $test) {
           $test->update([
               'done'=>1
           ]);
           \Log::info("run test".$test->id);
        }
    }
}
