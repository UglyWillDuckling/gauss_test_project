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

        public function friends(){
            
            return 
                $this->friendsOfMine()->wherePivot('accepted', true)
                ->get()->merge(
                    $this->friendOf()->wherePivot('accepted', true)
                    ->get()
                );
        }

        public function friendRequests()
        {
            return $this->friendsOfMine()->wherePivot('accepted', false)->get();
        }

        public function friendRequestsPending(){
            return $this->friendOf()->wherePivot('accepted', false)->get();
        }
        
        public function addFriend(User $user){
            $this->friendOf()->attach($user->id);
        }

        public function acceptFriendRequest(User $user){
            $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
                'accepted' => true
            ]);
        }

        public function isFriendsWith(User $user){
            return (bool) $this->friends()->where('id', $user->id)->count();
        }

        public function myEvents(){

            //return just the users events
            return $this->hasMany('App\Models\Event', 'user_id');
        }

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
         * retrieve all the votes from this user
         * @return [type] [description]
         */
        public function votes(){
            return $this->hasMany('App\Models\Vote');
        }
    }
