<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Messenger extends Model {
    protected $table = 'messenger';
    public $timestamps = false;
    public $fillable = [
        'id',
        'name'
    ];

    public function channels() {
        return $this->hasMany(Channel::class, 'messenger_id');
    }

    public function channelsOfModeration() {
        return $this->hasMany(ChannelOfModeration::class, 'messenger_id');
    }
}
