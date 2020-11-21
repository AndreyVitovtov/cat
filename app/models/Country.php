<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    protected $table = 'countries';
    public $timestamps = false;
    public $fillable = [
        'id',
        'name'
    ];

    public function channels() {
        return $this->hasMany(Channel::class, 'countries_id');
    }

    public function topChannels() {
        return $this->belongsToMany(
            Channel::class,
            'channels_top_countries',
            'countries_id',
            'channels_id'
        );
    }
}
