<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetSecret extends Model
{
    use HasFactory;

    protected $table = 'reset_password_secrets';
    protected $fillable = [
        'email',
        'secret',
        'secret_expires_at',
        'secret_is_fresh',
        'created_at'
    ];
}
