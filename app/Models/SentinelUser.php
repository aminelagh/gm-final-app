<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SentinelUser extends EloquentUser
{

}
