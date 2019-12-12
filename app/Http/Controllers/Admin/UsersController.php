<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('login');  // moras da budes ulogovan da bi koristio ostale rute
        $this->middleware('guest')->only('login');
    }

    public function index()
    {
        //$users = User::where('deleted', 0)->get();
        $users = User::notdeleted()->get();
        
        return view('admin.users.index', compact('users'));
    }

    public function login()
    {
        if (request()->isMethod('post')) {
            // validacija forme
            request()->validate([
                'email' => 'required|string|email',
                'password' => 'required',
            ]);
            //proba logovanja
            if (Auth::attempt([
                'email' => request('email'),
                'password' => request('password'),
                'active' => 1,
                'deleted' => 0,
            ])) {
                //TRUE- redirect na welcome ili tamo gde je hteo da ode ranije
                return redirect()->intended(route('users.welcome'));
            } else {
                //FALSE - redirect back sa greskom da je los email ili lozinka
                return redirect(route('users.login'))
                    ->withErrors(['email' => trans('auth.failed')])
                    ->withInput(['email' => request('email')]);
                    //ovo radimo da bismo preneli greske i email koji je upisan kada redirektujemo korisnika na login
            }
        }
        return view('admin.users.login');
    }

    public function welcome()
    {
        return view('admin.users.welcome');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store()
    {// validacija
        $data = request()->validate([                           // request->validate vraca niz sa validirani podacima, ali ovo nema u svim verzijama Laravel-a
            'name' =>'required|string|min:3|max:191',
            'email' =>'required|string|email|unique:users|max:191',
            'password' =>'required|string|min:5|max:191|confirmed',
            'role' =>'required|string|in:administrator,moderator',
            'phone' =>'nullable|string|min:5|max:191',
            'address' =>'nullable|string|min:5|max:191',
        ]);

        // dopuna $data
        $data['active'] = 1;
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully created user!!!');

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(User $user)
    {
        // validacija
         request()->validate([                           
            'name' =>'required|string|min:3|max:191',
            'role' =>'required|string|in:administrator,moderator',
            'phone' =>'nullable|string|min:5|max:191',
            'address' =>'nullable|string|min:5|max:191',
        ]);

        $user->name = request()->name;
        $user->role = request()->role;
        $user->phone = request()->phone;
        $user->address = request()->address;

        $user->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully edited user ' . $user->name . '!!!');

        return redirect()->route('users.index');
    }

    public function changestatus(User $user)
    {
        if($user->active == 1){
            $user->active = 0;
        } else {
            $user->active = 1;
        }

        $user->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully changed status for user ' . $user->name . '!!!');

        return redirect()->route('users.index');
    }

    public function delete(User $user)
    {
        //hard delete
        //$user->delete();

        //soft delete
        $user->deleted = 1;
        $user->deleted_by = auth()->user()->id;
        $user->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully deleted user ' . $user->name . '!!!');
                
        return redirect()->route('users.index');
    }

    public function logout()
    { // uradi logout
            Auth::logout();
        //redirect gde zeli vlasnik portala
        return redirect()->route('users.login')->withErrors(['message' => 'Thank you, come again!!!']);

    }
}
