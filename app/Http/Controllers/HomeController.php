<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use Auth;

    class HomeController extends Controller
    {

        public function getIndex()
        {
            if(!Auth::user()){
                return redirect('signup');
            }

            //get the upcoming events from this user and this users friends
            $events = Auth::user()->events();

            return view('home.index')->with('events', $events);
        }
        
    }