<?php
namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Vote extends Model 
    {

        protected $fillable = ['user_id', 'event_id', 'answer'];


        public function user(){
            return $this->belongsTo('App\Models\User', 'user_id');
        }

        public function post(){
            return $this->belongsTo('App\Models\User', 'user_id');
        }
    }
