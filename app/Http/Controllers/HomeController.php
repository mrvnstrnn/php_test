<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function component_viewer ($user_id)
    {
        try {
            $my_component = \DB::table('user_components')
                            ->where('user_id', $user_id)
                            ->first();
                            
            $users = '';

            if ( !is_null($my_component) ) {
                if ( $my_component->components == 'admin-component' ) {
                    $users = User::get();
                }
                $my_component = $my_component->components;
            } else {
                $my_component = 'no-component';
            }


            return view('my-component', 
                            compact(
                                'my_component',
                                'users'
                            )
                        );

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
