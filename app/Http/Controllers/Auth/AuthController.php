<?php



namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Session;

use App\Models\User;

use Hash;
use Faker\Generator as Faker;



class AuthController extends Controller {

    public function index() {
        return view('auth.login');
    }  


    public function registration() {
        return view('auth.registration');
    }


    public function postLogin(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
            ->withSuccess('You have Successfully loggedin');
        }
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function generateRandomUser(Request $request) {  
        set_time_limit(0);
        $user = new User();
        $user_data = array();
        for($n =0; $n<=10000;$n++) {
            $data = array('name'=>rand(),'email'=>rand().'@gmail.com','password'=>Hash::make('Testing@123'));
            $user_data[] = $data
        }
        User::insert($user_data);
        echo "success"; die;
    }

    public function postRegistration(Request $request) {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("registration")->withSuccess('Great! You have Successfully registered');
    }


    public function dashboard() {
        $employees = User::paginate(10);
        if(Auth::check()) {
            return view('dashboard', compact('employees'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    public function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

}