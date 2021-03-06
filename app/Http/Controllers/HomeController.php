<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Event;
    use Auth;

    class HomeController extends Controller
    {
        public function getIndex()
        {
            $user = Auth::user();

        //get the upcoming events from this user and this users friends
            $events = Event::where(function ($query) use($user){
                return $query
                    ->where('user_id', $user->id)
                    ->orWhereIn('user_id', $user->friends()->lists('id'));
            })
            ->whereRaw(" `when` > UTC_TIMESTAMP()")
            ->with('User')
            ->with('votes')
            ->orderBy('when', 'asc')
            ->paginate(15);


            return view('home.index')
                ->with('events', $events)
                ->with('user', $user)
            ;
        }    
    }