<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [AuthController::class, "home"]);
Route::get("/login", [AuthController::class, "index"])->name("login");
Route::post("/post-login", [AuthController::class, "postLogin"])->name(
    "login.post"
);
Route::get("/registration", [AuthController::class, "registration"])->name(
    "register"
);
Route::post("/post-registration", [
    AuthController::class,
    "postRegistration",
])->name("register.post");
Route::get("/dashboard", [AuthController::class, "dashboard"]);
Route::get("/logout", [AuthController::class, "logout"])->name("logout");
Route::get("/fakeuser", [AuthController::class, "generateRandomUser"])->name(
    "fakeuser"
);
Route::get("/spa", [AuthController::class, "indexPage"])->name("index");
Route::get("/send-mail", [MailController::class, "sendMail"])->name("mail");
