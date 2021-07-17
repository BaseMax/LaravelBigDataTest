<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use Illuminate\Console\Command;

class fakeuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "user:fake";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Command description";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new AuthController())->generateRandomUser();
        return 0;
    }
}
