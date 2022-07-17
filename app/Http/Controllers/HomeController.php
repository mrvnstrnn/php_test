<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use Validator;

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
            $posts = '';

            if ( !is_null($my_component) ) {
                if ( $my_component->components == 'admin-component' ) {
                    $users = User::get();
                } else {
                    $posts = Post::get_approved_post(\Auth::id(), [0, 1, 2]);
                }
                $my_component = $my_component->components;
            } else {
                $my_component = 'no-component';
            }


            return view('my-component', 
                            compact(
                                'my_component',
                                'users',
                                'posts'
                            )
                        );

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function post_status (Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                '*' => ['required']
            ]);

            if ( $validator->passes() ) {
            
                Post::create([
                    'user_id' => \Auth::id(),
                    'title' => $request->get('title'),
                    'paragraph' => $request->get('paragraph'),
                    'status' => 0,
                ]);
    
                return response()->json([
                    'error' => false,
                    'message' => "Successfully post status."
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => $validator->errors()
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function view_user ($user_id)
    {
        try {
            $posts = Post::get_approved_post($user_id, [0]);

            $user = User::where('id', $user_id)
                        ->first();

            return view('view-user', 
                            compact(
                                'posts',
                                'user'
                            )
                        );

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function approve_reject (Request $request)
    {
        try {
            Post::where('id', $request->get('id'))
                ->update([
                    'status' => $request->get('action') == 'reject' ? 2 : 1
                ]);

            return response()->json([
                'error' => false,
                'message' => "Successfully " .$request->get('action') == 'reject' ? "rejected " : "approved ". "post."
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }
}
