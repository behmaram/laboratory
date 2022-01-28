<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Turn;
//use App\Models\User;
//use App\Classes\MessageClass;
class runTurn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:turn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'do test when time recive';

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
        $turnObj = new Turn();
      //  $messageObj = new MessageClass();
      //  $userObj = new User();
        $allTestsTimeTorun =$turnObj->doingTest();
       
        if ($allTestsTimeTorun){
            foreach ($allTestsTimeTorun as $test) {
                $test->update([
                    'done'=>1
                ]);
                \Log::info("run test".$test->id);
             }
        }

    }
}
