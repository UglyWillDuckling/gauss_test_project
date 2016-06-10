<?php
namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Event extends Model 
    {
        protected $table = 'events';

        protected $fillable = [

            'title',
            'description',
            'when'
        ];

        protected $dates = ['when'];


        public function user(){
            return $this->belongsTo('App\Models\User', 'user_id');
        }

        public function votes(){
            return $this->hasMany('App\Models\Vote');
        }
    }