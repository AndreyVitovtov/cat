<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $table = 'categories';
    public $timestamps = false;
    public $fillable = [
        'id',
        'name'
    ];

    public function channels() {
        return $this->hasMany(Channel::class, 'categories_id');
    }

    public function topChannels() {
        return $this->belongsToMany(
            Channel::class,
            'channels_top_categories',
            'categories_id',
            'channels_id'
        );
    }
}
