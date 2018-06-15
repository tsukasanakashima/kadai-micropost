<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MicropostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
            return view('welcome' , $data);
        
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:255',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect('/');
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);

        if (\Auth::user()->id === $micropost->user_id) {
            $micropost->delete();
        }

        return redirect()->back();
    }
    
    
    public function edit($id)
    {
        
        $micropost = \App\Micropost::find($id);
 
        
        return view('users.edit',['micropost' => 'users.edit','micropost' => $micropost]);
    }
    
    public function update(Request $request, $id)
    {
        $micropost = \App\Micropost::find($id);
        
        $micropost->content = $request->content;
        $micropost->save();
        
        return redirect('/');
    }
    
    public function status_update(Request $request, $id)
    {
        $micropost = \App\Micropost::find($id);
        
        $micropost->status = $request->status;
        $micropost->save();
        
        return redirect('/');
    }
}