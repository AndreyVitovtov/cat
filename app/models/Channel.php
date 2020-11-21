<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model {
    protected $table = 'channels';
    public $timestamps = false;
    public $fillable = [
        'id',
        'name',
        'avatar',
        'users_id',
        'moderation',
        'countries_id',
        'categories_id'
    ];

    public function country() {
        return $this->belongsTo(Country::class, 'countries_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
