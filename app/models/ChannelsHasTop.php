<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ChannelsHasTop extends Model {
    protected $table = 'channels_has_top';
    public $timestamps = false;
    public $fillable = [
        'id',
        'top_id'
    ];

    public function top() {
        return $this->belongsTo(Top::class, 'top_id');
    }
}
