<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\User;
    use Auth;

    class SearchController extends Controller
    {

        public function postIndex(Request $request){

            $term = $request->input('term');

            $users = User::where('username',"like", "%{$term}%")->get();

            return view('search.index')->with('users', $users)->with('term', $term);
        }   
    }