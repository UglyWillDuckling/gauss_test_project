<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Models\Event;
    use App\Models\Vote;
    use Auth;
    use DateTime;
    use DateTimeZone;
    use DB;

    class EventController extends Controller
    {

        /**
         * show events for a user
         * @param  [string] $username 
         * @return [object] return a view          
         */
        public function getIndex($username)
        {
            if(Auth::check())//in case the user is logged in check the relationship between the two users
            {
                if(Auth::user()->username == $username)//first see if this is the users event page
                {
                   $user = Auth::user(); 
                }
                else{ //if not find the user requested
                    $user = User::where('username', '=', $username)->firstOrFail();
                }
                $status = Auth::user()->relationStatus($user);//finally get the users relationship
                                                              //if one exists    
            }
            else{
                $status = 'none';          
            }

            
            $events = $user->myEvents()
                ->whereRaw(" `when` > UTC_TIMESTAMP()")    
                ->with('User')
                ->with('votes')
                ->orderBy('when', 'asc')
                ->get()
            ;

            return view('events.index')
                ->with('user', $user)
                ->with('events', $events)
                ->with('status', $status)
            ;
        }

        public function getAdd()
        {
            return view('events.add');
        }


        public function postAdd(Request $request)
        {
            $this->validate($request, [
                'title' => 'required|min:3',
                'description' => 'required|min:6',
                'time' => 'required',
                'location' => 'required|min:3',
            ]);   

            $t = str_replace('T', ' ', $request->input('time'));

            $date = DateTime::createFromFormat('Y-m-d H:i', $t);
            
            if(!$date){
                redirect()->back()->with('the given time is invalid.');
            }

            $stamp = $date->getTimestamp();
            if( !( $stamp > (time() + (60*60*2)) ) )
            {
                redirect()->back()->with('the given time is invalid.');
            }

            $date->setTimezone(new DateTimeZone('UTC'));

            //save the new event
            $event = new Event([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'when' => $date->format('Y-m-d H:i:s'),
                'location' => $request->input('location'),
            ]);

            Auth::user()->myEvents()->save($event);

            return redirect()
                ->route('events', [Auth::user()->username])
                ->with('info', 'event added to schedule.')
            ;
        }

        public function getVote($eventId, $answer){        

            $event = Event::where('id', '=', $eventId)
                ->where('locked', '=', '0')
                ->with('User')
                ->firstOrFail();


            if(!Auth::user()->isFriendsWith($event->user))
            {
                return redirect()->back()->with('info', 'not friends');
            }


            $vote = Vote::firstOrNew([
                'user_id' => Auth::user()->id,
                'event_id' => $eventId
            ]);

            $vote->answer = $answer;
            $vote->save();

            return redirect()->back();
        }

        public function getLocking($eventId, $order){

            $event = Auth::user()
                ->myEvents()
                ->where('id', '=', $eventId)
                ->where('locked', '=', !$order)
                ->firstOrFail();

            $event->locked = $order;//locking the event
            $event->save(); 

            return redirect()->back()->with('info', 'event locked.');
        }
    }