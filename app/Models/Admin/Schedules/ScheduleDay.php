<?php

namespace App\Models\Admin\Schedules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{
    use HasFactory;
    protected $table = "schedule_days";
    protected $guarded = ['id'];
    protected $casts = [
        'id'                => 'integer',
        'admin_id'          => 'integer',
        'name'              => 'string',
        'slug'              => 'string',
        'status'            => 'integer'
    ];
    protected $appends = [
        'editData',
    ];

    public function getEditDataAttribute()
    {

        $data = [
            'id'      => $this->id,
            'name'      => $this->name,
            'slug'      => $this->slug,
            'status'      => $this->status,
        ];

        return json_encode($data);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function dailySchedule()
    {
        return $this->hasMany(DailySchedule::class,'day_id');
    }

    public function scopeBanned($query)
    {
        return $query->where('status', false);
    }

    public function scopeSearch($query,$text)
    {
        return $query->Where("name","like","%".$text."%");
    }
}
