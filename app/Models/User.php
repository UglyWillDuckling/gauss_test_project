<?php
namespace App\Models;

    use Illuminate\Auth\Authenticatable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
    use DB;

    class User extends Model implements AuthenticatableContract
    {
        use Authenticatable;

        protected $table = "users";

        protected $fillable = [
            'username',
            'email', 
            'first-name',
            'last-name',
            'password'
        ];

        protected $hidden = [
            'password',
            'remember-token',
        ];

        public function friendsOfMine(){
            return $this
            ->belongsToMany('App\Models\User', 'friends', 'user_id', 'friend_id');
        }

        public function friendOf()
        {
            return $this
            ->belongsToMany('App\Models\User', 'friends', 'friend_id', 'user_id');
        }

        /**
         * merge the two relationship results into one to get all of the users friends
         * @return Collection object 
         */
        public function friends(){
            
            return 
                $this->friendsOfMine()->wherePivot('accepted', true)
                ->get()->merge(
                    $this->friendOf()->wherePivot('accepted', true)
                    ->get()
                );
        }

        /**
         * get the requests this user received but not yet answered
         * @return Collection object
         */
        public function friendRequests()
        {
            return $this->friendsOfMine()->wherePivot('accepted', false)->get();
        }

        /**
         * get pending requests sent from this user
         * @return Collection object
         */
        public function friendRequestsPending(){
            return $this->friendOf()->wherePivot('accepted', false)->get();
        }
        
        public function addFriend(User $user){
            $this->friendOf()->attach($user->id);
        }

        /**
         * update the pivot table to true
         * @param  User   $user 
         * @return void
         */
        public function acceptFriendRequest(User $user){
            $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
                'accepted' => true
            ]);
        }

        public function isFriendsWith(User $user){
            return (bool) $this->friends()->where('id', $user->id)->count();
        }

        /**
         * determines wheter the user has a relationship with a different user
         * @param  object $user 
         * @return object or false     
         */
        public function hasRelationWith($user)
        {         
            return DB::table('friends')
            ->where([
                'user_id' => $this->id,
                'friend_id' => $user->id              
            ])
            ->orWhere([
                'user_id' => $user->id,
                'friend_id' => $this->id
            ])
            ->first();
        }
        /**
         * returns the type of relation between two users
         * @param  User   $user
         * @return string string representation of the relationship     
         */
        public function relationStatus(User $user){

            if($this == $user){
                return 'own';
            }

            if(!$rel = $this->hasRelationWith($user))
            {
                return 'send';
            }

            if($rel->accepted == '1'){
                return 'friends';
            }

            if($rel->friend_id == $this->id){ 
                return 'sent';
            }

            return 'received';
        }

         /**
         * hasMany relation for users events
         * @return object
         */
        public function myEvents(){   
            return $this->hasMany('App\Models\Event', 'user_id');
        }

        /**
         * hasMany relation for the users votes
         * @return object
         */
        public function votes(){
            return $this->hasMany('App\Models\Vote');
        }
    }
