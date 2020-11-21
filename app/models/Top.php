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

    public function channels() {
        return $this->hasMany(Channel::class, 'channels_id');
    }

    public function topChannels() {
        return $this->belongsToMany(
            Channel::class,
            'channels_has_top',
            'top_id',
            'channels_id'
        );

    }
}
