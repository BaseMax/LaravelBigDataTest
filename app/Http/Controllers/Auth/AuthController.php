<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Session;

use App\Models\User;

use Hash;
use Faker\Generator as Faker;
use DB;

class AuthController extends Controller
{
    public function index()
    {
        return view("auth.login");
    }

    public function registration()
    {
        return view("auth.registration");
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);
        $credentials = $request->only("email", "password");
        if (Auth::attempt($credentials)) {
            return redirect()
                ->intended("dashboard")
                ->withSuccess("You have Successfully loggedin");
        }
        return redirect("login")->withSuccess(
            "Oppes! You have entered invalid credentials"
        );
    }

    public function generateRandomUser()
    {
        set_time_limit(0);
        try {
            DB::beginTransaction();
            for ($r = 0; $r <= 1000; $r++) {
                for ($n = 0; $n <= 10000; $n++) {
                    $data = [
                        "name" => uniqid(),
                        "email" => uniqid() . "@gmail.com",
                        "password" => "Testing@123",
                    ];
                    DB::table("users")->insert($data);
                }
            }
            DB::commit();
            echo "success";
            die();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6",
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("registration")->withSuccess(
            "Great! You have Successfully registered"
        );
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        // Check email
        $user = User::where("email", $fields["email"])->first();

        // Check password
        if (!$user || !Hash::check($fields["password"], $user->password)) {
            return response(
                [
                    "message" => "Bad creds",
                ],
                401
            );
        }

        $token = md5(rand(1, 10) . microtime());
        $response = [
            "status" => 1,
            "alert" => [
                "has" => 1,
                "title" => "Sign in",
                "message" => "Welcome " . $user->name,
            ],
            "result" => [
                "jwt_token" => $token,
            ],
        ];

        return response($response, 201);
    }

    public function home()
    {
        if (Auth::check()) {
            return redirect("dashboard");
        }
        return redirect("login")->withSuccess("Opps! You do not have access");
    }

    public function dashboard()
    {
        $employees = User::paginate(10);
        if (Auth::check()) {
            return view("dashboard", compact("employees"));
        }
        return redirect("login")->withSuccess("Opps! You do not have access");
    }

    public function create(array $data)
    {
        return User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect("login");
    }
    public function indexPage()
    {
        return view("index");
    }
    public function genrateUsers($perpage = 20, $page = 1)
    {
        // $users = User::all(); // Memory problem with 10M rows!
        // $users = User::paginate(); // Very slow!
        // $users = User::take($perpage)->skip(($page-1) * $perpage)->get(); // This will return all of the columns!
        $users = DB::table("users")
            ->select("id", "name", "email")
            ->take($perpage)
            ->skip(($page - 1) * $perpage)
            ->get();
        $response = [
            "status" => 1,
            "alert" => [
                "has" => 1,
            ],
            "result" => $users,
        ];
        return response($response, 201);
    }

    // public function get_listOfJobs($userId):
    // {
    //     $user = User::find($userId);
    //     note: $user has a relationship with jobs.
    //     $secondQuery = $user->jobs()->where('is_completed', true)

    //     if ($userId == 2) {
    //         $query = $secondQuery->where('status', 1)->where('main', false);
    //     } elseif ($userId == 3) {
    //         $query = $secondQuery->where('status', 2)->where('main', true);
    //     } else {
    //         $query = $secondQuery->where('status', 0);
    //     }

    //     $jobs = $query->get();

    //     foreach ($jobs as $job) {
    //         $job->name = 'Name is ' . $job->title;
    //         $job->providerList = [];

    //         // job can have multiple provider object
    //         $job->providerList = array_map(function($provider) {
    //             return $provider->first_name.' '. $provider->last_name;
    //         }, $job->providers);
    //         Mail::to($user->email)->send(new JobFechted('Fetched job id: ' . $job->id));
    //     }

    //     return $jobs;
    // }
}
