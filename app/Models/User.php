<?php

namespace App\Models;

use App\Constants\GlobalConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $appends = ['fullname','userImage','stringStatus','lastLogin'];
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ["id"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'firstname'           => 'string',
        'lastname'            => 'string',
        'username'            => 'string',
        'email'               => 'string',
        'country'             => 'string',
        'mobile_code'         => 'string',
        'mobile'              => 'string',
        'full_mobile'         => 'string',
        'password'            => 'string',
        'image'               => 'string',
        'status'              => 'integer',
        'email_verified_at'   => 'datetime',
        'address'             => 'object',
        'email_verified'      => 'integer',
        'ver_code'            => 'integer',
        'ver_code_send_at'    => 'datetime',
        'device_id'           => 'string',
        'social_type'         => 'string',
        'remember_token'      => 'string',
        'deleted_at'          => 'datetime',
        'created_at'          => 'datetime',
        'updated_at'          => 'datetime',
    ];

    public function scopeEmailUnverified($query)
    {
        return $query->where('email_verified', false);
    }

    public function scopeEmailVerified($query) {
        return $query->where("email_verified",true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', false);
    }

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getUserImageAttribute() {
        $image = $this->image;

        if($image == null) {
            return files_asset_path('profile-default');
        }else if(filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }else {
            return files_asset_path("user-profile") . "/" . $image;
        }
    }

    public function passwordResets() {
        return $this->hasMany(UserPasswordReset::class,"user_id");
    }

    public function scopeGetSocial($query,$credentials) {
        return $query->where("email",$credentials);
    }

    public function getStringStatusAttribute() {
        $status = $this->status;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if($status == GlobalConst::ACTIVE) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => "Active",
            ];
        }else if($status == GlobalConst::BANNED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Banned",
            ];
        }
        return (object) $data;
    }

    public function loginLogs(){
        return $this->hasMany(UserLoginLog::class);
    }

    public function getLastLoginAttribute() {
        if($this->loginLogs()->count() > 0) {
            return $this->loginLogs()->get()->last()->created_at->format("H:i A, d M Y");
        }

        return "N/A";
    }

    public function scopeSearch($query,$data) {
        return $query->where(function($q) use ($data) {
            $q->where("username","like","%".$data."%");
        })->orWhere("email","like","%".$data."%")->orWhere("full_mobile","like","%".$data."%");
    }
}
