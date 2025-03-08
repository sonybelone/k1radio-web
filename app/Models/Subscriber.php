<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function getEditDataAttribute() {
        $data = [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'reply'     => ($this->reply == true) ? 1 : 0,
        ];

        return json_encode($data);
    }
}
