<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ChannelOfModeration extends Model {
    protected $table = 'channels_of_moderation';
    public $timestamps = false;
    public $fillable = [
        'id',
        'users_id',
        'messenger_id',
        'link',
        'date',
        'time'
    ];

    public function messenger() {
        return $this->belongsTo(Messenger::class, 'messenger_id');
    }
}
