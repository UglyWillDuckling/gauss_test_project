<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use Auth;

    class EventController extends Controller
    {
        public function getIndex($username)
        {

            $user = User::where('username', '=', $username)->firstOrFail();

            $events = $user->myEvents()
                ->where('locked', '=', '0')
                ->whereRaw(" `when` > UTC_TIMESTAMP()")
                ->orderBy('when', 'desc')
                ->get()
            ;

            foreach ($events as $event) {
                
            }

            return view('events.index')->with('user', $user)->with('events', $events);
        }


    }