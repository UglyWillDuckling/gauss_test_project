<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use Auth;
    use DB;

    class FriendController extends Controller
    {
        /**
         * here we display the users friends and pending friend requests
         * we also offcourse give the opportunity to the user to
         * respond to the received requests and delete his or 
         * hers current friends
         * @return [type] [description]
         */
        public function getIndex()
        {
            $user = Auth::user();

            return view('friends.index')
            ->with('user', $user)
            ->with( 'friends', $user->friends() )
            ->with( 'requests', $user->friendRequests() );
        }

        public function getDelete($username){

            $friend = User::where('username', '=', $username)->firstOrFail();

            $relation = Auth::user()->hasRelationWith($friend);

            if(!$relation || $relation->accepted == false)
            {
                return redirect()->route('home'); //if the users don't have a relation or if they aren't
                                                 //friends, there's obviously nothing to do here
            }

            DB::table('friends')
            ->where([
                'user_id' => $relation->user_id,
                'friend_id' => $relation->friend_id
            ])
            ->delete();
            #we could do this with the User relations but it's easier this way

            return back()->with('info', 'friend deleted.');
            ;
        }

        /**
         * this method sends a friend request to a given user
         * @param  [string] $username 
         * @return [view] returns the user back to the events page they came from
         */
        public function getAdd($username){

            $friend = User::where('username', '=', $username)->firstOrFail();

            //check if the users are already friends or whether a friend request was send
            if(Auth::user()->hasRelationWith($friend))
            {
                return redirect()->route('home');
            }

            Auth::user()->addFriend($friend);//sending the request

            return redirect()
                ->route('events', ['username' => $username])
                ->with('info', 'your request has been sent.')
            ;
        }

        /**
         * accept a friend request 
         * @param  [string] $username 
         * @return object   returns the user to the previous page or home
         */
        public function getAccept($username)
        {
            $friend = User::where('username', '=', $username)->firstOrFail();

            $user = Auth::user();
            if(!$user->friendRequests($friend))
            {
                return redirect()->route('home');
            }

            $user->acceptFriendRequest($friend);

             return redirect()
                ->back()
                ->with('info', "you and {$username} are now friends.");
            ;
        }
    }
