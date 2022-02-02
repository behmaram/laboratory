<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Turn;
use App\Models\User;
use App\Classes\MessageClass;
class cancelReservetion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:reservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel unpaid reserved turn ';

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
        $messageObj = new MessageClass();
        $userObj = new User();
        $records = $turnObj->unpaid();
        
        foreach ($records as $record) {
            try{
                $user = $userObj->find($record->user_id);
                $emailData = array('title' => ' آزمایشگاه الزهرا');
                $messageObj->sendEmail($user->email, $emailData , 'email.cancelReservation');
            } catch (\Exeption $e){
                \Log::info("error in sending cancel reservation");
            }
            $record->delete();
        }
    }
}
