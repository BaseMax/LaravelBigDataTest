<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "user:gets";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get list of all users";

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
        print "Hello, World!\n";
        return 0;
    }
}
