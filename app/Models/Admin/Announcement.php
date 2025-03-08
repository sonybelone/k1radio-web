<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $table = "announcement";
    protected $guarded = ['id'];
    protected $casts = [
        'id'               => 'integer',
        'admin_id'         => 'integer',
        'category_id'      => 'integer',
        'name'             => 'object',
        'slug'             => 'string',
        'image'            => 'string',
        'tags'             => 'object',
        'details'          => 'object',
        'status'           => 'integer'
    ];
    protected $appends = [
        'editData',
    ];
    public function getEditDataAttribute() {

        $data = [
            'id'      => $this->id,
            'admin_id '      => $this->admin_id,
            'category_id'      => $this->category_id,
            'name'      => $this->name,
            'slug'      => $this->slug,
            'tags'      => $this->tags,
            'image'      => $this->image,
            'details'      => $this->details,
            'status'      => $this->status,
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];

        return json_encode($data);
    }
    public function category()
    {
        return $this->belongsTo(AnnouncementCategory::class, 'category_id');
    }
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', false);
    }

    public function scopeSearch($query,$text) {
        $query->Where("name","like","%".$text."%");
    }

}
