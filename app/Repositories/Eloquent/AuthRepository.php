<?php


namespace App\Repositories\Eloquent;

use App\Models\TechnicalAdminLogin;
use App\Models\Phone;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Carbon\Carbon;
use App\Traits\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    use ThrottlesLogins;

    public function __construct()
    {
        $this->setModel(User::class);
    }


}
