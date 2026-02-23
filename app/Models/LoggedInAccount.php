<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoggedInAccount extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'user_id', 'logged_at', 'last_active_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
