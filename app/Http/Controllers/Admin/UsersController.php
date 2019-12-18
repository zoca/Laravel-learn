<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'resetpassword', 'resetLink']);  // moras da budes ulogovan da bi koristio ostale rute
        $this->middleware('isadmin')->only(['index', 'create', 'store', 'changestatus', 'delete']);
        $this->middleware('guest')->only(['login', 'resetpassword']);
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
    { // validacija
        $data = request()->validate([                           // request->validate vraca niz sa validirani podacima, ali ovo nema u svim verzijama Laravel-a
            'name' => 'required|string|min:3|max:191',
            'email' => 'required|string|email|unique:users|max:191',
            'password' => 'required|string|min:5|max:191|confirmed',
            'role' => 'required|string|in:administrator,moderator',
            'phone' => 'nullable|string|min:5|max:191',
            'address' => 'nullable|string|min:5|max:191',
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
        $this->chechPrivilegies($user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->chechPrivilegies($user);

        // validacija
        request()->validate([
            'name' => 'required|string|min:3|max:191',
            'role' => 'required|string|in:administrator,moderator',
            'phone' => 'nullable|string|min:5|max:191',
            'address' => 'nullable|string|min:5|max:191',
        ]);

        $user->name = request()->name;

        $user->phone = request()->phone;
        $user->address = request()->address;

        if (auth()->user()->role == User::ADMINISTRATOR) {
            $user->role = request()->role;
        }

        $user->save();

        if (auth()->user()->role == User::ADMINISTRATOR) {
            session()->flash('message-type', 'success');
            session()->flash('message-text', 'Successfully edited user ' . $user->name . '!!!');
            return redirect()->route('users.index');
        } else {
            session()->flash('message-type', 'success');
            session()->flash('message-text', 'Successfully edited user ' . $user->name . '!!!');
            return redirect()->route('users.welcome');
        }
    }

    public function changestatus(User $user)
    {
        if ($user->active == 1) {
            $user->active = 0;
        } else {
            $user->active = 1;
        }

        $user->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully changed status for user ' . $user->name . '!!!');

        return redirect()->route('users.index');
    }

    public function changepassword(User $user)
    {
        $this->chechPrivilegies($user);

        if (request()->isMethod('post')) {
            //only on form submit
            $data = request()->validate([
                'password' => 'required|string|min:5|max:191|confirmed',
            ]);

            $user->password = Hash::make(request()->password);
            $user->save();

            session()->flash('message-type', 'success');
            session()->flash('message-text', 'Successfully changed password for user ' . $user->name . '!!!');


            if (auth()->user()->role == User::ADMINISTRATOR) {
                return redirect()->route('users.index');
            } else {
                return back();
            }
        }

        return view('admin.users.changepassword', compact('user'));
    }

    public function resetpassword(User $user)
    {
        if (request()->isMethod('post')) {
            //only on form submit
            // validacija
            request()->validate([
                'email' => 'required|string|email|max:191',
            ]);
                $token = md5('cubes123');
            if($user = User::where('email', 'like', request()->email)->first()){
                DB::table('password_resets')->insert([
                    ['email' => request()->email, 'token' => $token, 'created_at' => Carbon::now()],
                ]);

                $resetLink = route('users.resetlink', ['token' => $token]);
                Mail::to(request()->email)->send(new ResetPassword($resetLink)); 
                
            }
           
            session()->flash('message-type', 'success');
            session()->flash('message-text', 'Successfully send email!!!');
            return redirect()->route('users.login');
        }

        return view('admin.users.resetpassword');
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

    protected function chechPrivilegies(User $user)
    {
        if (auth()->user()->role == User::MODERATOR && auth()->user()->id != $user->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
