<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use Auth;

    class AuthController extends Controller
    {
        public function getSignUp()
        {
            return view('auth.signup');
        }

        public function postSignUp(Request $request){
           /**
            * validate the form being submitted
            * if something is wrong an exception will be thrown(ValidationException)
            * all the errors will automatically be passed through to the view
            */
           $this->validate($request,[
                'email' => 'required|unique:users|email|max:255',
                'username' => 'required|unique:users|alpha_dash|max:25',
                'password' => 'required|min:6',
           ]);

            User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            ]);

            return redirect()
               ->route('auth.signin')
               ->with('info', 'your account has been created.')
            ;
        }

        public function getSignin()
        {
            return view('auth.signin');
        }

        public function postSignin(Request $request){

            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',            
            ]);

            if(!Auth::attempt($request->only(['email', 'password']), $request->has('
                remember')))//in case the authentication fails
            {
              return redirect()->back()->with('info', 'could not sign you in with those details.');
            }

            return redirect()->route('home')->with('info', 'you have been signed in.');
        }

        public function getSignout(){

            Auth::logout();

            return redirect()->route('home');
        }
    }