<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Turn extends Model
{
    use HasFactory;

    protected $table = 'turns';

    protected $fillable = [
        'user_id',
        'test_id',
        'turn_time',
        'result',
        'done',
        'payment',
    ];

    public function checkReservation($turnTime)
    {
        $beforeTurnTime = Carbon::parse($turnTime)->addMinutes(-15);
        $afterTurnTime = Carbon::parse($turnTime)->addMinutes(+15);
        $record = self::where('done', 0)->where('turn_time', '>', $beforeTurnTime)->where('turn_time', '<', $afterTurnTime)->first();
        return $record;
    }

    // Users did these tests
    public function getAllWithoutResult($filter)
    {
        $records = self::where('done', 1)->where('payment', 1)
            ->leftJoin('users', 'users.id', '=', 'turns.user_id')
            ->leftJoin('tests', 'tests.id', '=', 'turns.test_id')
            ->selectRaw('users.name as user_name,
                     users.national_code,
                     tests.name as test_name,
                     turns.id as id,
                     turn_time,tests.estimate');
        if ($filter == "result") {
            $records = $records->whereNotNull('result');
        } else if ($filter == "no-result") {
            $records = $records->whereNull('result');
        }
        $records = $records->get();

        return $records;
    }

    public function setResult($id, $result)
    {
        $test = self::find($id);
        $test->update([
            'result' => $result
        ]);
        return $test;
    }

    public function getDoneTurnByUserId($userId, $hasResult)
    {
        $records = self::where('user_id', $userId)->where('done', 1)->where('payment', 1)
            ->leftJoin('tests', 'tests.id', '=', 'turns.test_id');
        if ($hasResult == true) {
            $records = $records->whereNotNull('result');
        }
        $message = "جواب این آزمایش هنوز آماده نیست";
        $records = $records->selectRaw('tests.name as test_name,turns.*')->orderBy('id', 'DESC')->get();
        return $records;
    }

    public function doingTest(){

        $allTestsTimeTorun = self::where('done',0)->where('payment', 1)->where('turn_time','<=',Carbon::now())->get(); // شرط 1 بودن ستون پرداخت
        return $allTestsTimeTorun;

    }

    public function getHourFromDate($time)
    {
        if ($time) {
            $data = explode(' ', $time);
            $hour = $data[1];
            $times = explode(':', $hour);
            $hours = $times[0] . ':' . $times[1];
            return $hours;
        } else {
            return '___';
        }
    }

    public function test() {
        return $this->belongsTo(Test::class);
    }
}
