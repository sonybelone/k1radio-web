<?php

namespace App\Models\Admin\Schedules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySchedule extends Model
{
    use HasFactory;
    // protected $table = "daily_schedules";
    protected $guarded = ['id'];
    protected $casts = [
        'id'                => 'integer',
        'admin_id'          => 'integer',
        'day_id'            => 'integer',
        'name'              => 'string',
        'slug'              => 'string',
        'chat_link'         => 'string',
        'radio_link'        => 'string',
        'host'              => 'string',
        'description'       => 'string',
        'is_live'           => 'integer',
        'image'             => 'string',
        'status'            => 'integer',
        'start_time'        => 'string',
        'end_time'          => 'string'

    ];
    protected $appends = [
        'editData',
    ];
    public function getEditDataAttribute()
    {

        $data = [
            'id'         => $this->id,
            'day_id'     => $this->day_id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'chat_link'  => $this->chat_link,
            'radio_link'  => $this->radio_link,
            'image'      => $this->image,
            'host'       => $this->host,
            'description'=> $this->description,
            'status'     => $this->status,
            'is_live'     => $this->is_live,
            'start_time' => $this->start_time,
            'end_time'   => $this->end_time,
        ];

        return json_encode($data);
    }

    public function day()
    {
        return $this->belongsTo(ScheduleDay::class, 'day_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
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
