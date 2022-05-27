<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->call('cache:clear', ['--ansi' => true]);
        $this->call('route:clear', ['--ansi' => true]);
        $this->call('config:clear', ['--ansi' => true]);
        $this->call('view:clear', ['--ansi' => true]);
        return 0;
    }
}
