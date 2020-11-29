<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Top extends Model {
    protected $table = 'top';
    public $timestamps = false;
    public $fillable = [
        'id',
        'channels_id'
    ];

    public function channel() {
        return $this->belongsTo(Channel::class, 'channels_id');
    }
}
