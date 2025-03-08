<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserNotification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id'    => 'integer',
        'user_id' => 'integer',
        'type'  => 'string',
        'message'   => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeAuth(){
        $this->where('user_id', Auth::id());
    }
}
