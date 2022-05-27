<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class MakeStub extends Command
{

    /**
     * argumentName
     *
     * @var string
     */
    public $argument = 'stub';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:stub {stub : The Resource Directory and Model name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all stub files for CRUD';

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
    public function handle(): int
    {
        $stubPath = $this->argument('stub');

        $this->createModelRelatedStubs($stubPath);
        $this->createRequestStubs($stubPath);
        $this->createServiceStubs($stubPath);
        $this->createRepositoryStubs($stubPath);
        //$this->createViewStubs($stubPath)
        return 0;
    }


    /**
     * Create Model and Other Model Related Stubs
     * Migration, Seeder, Factory & Resource Controller
     *
     * @param string $modelPath
     * @return int
     */
    protected function createModelRelatedStubs(string $modelPath): int
    {
        return $this->call('create:model', [
            'name' => $modelPath,
            '--migration' => true,
            '--factory' => true,
            '--seed' => true,
            '--controller' => true
        ]);
    }

    /**
     * Create Default FormRequest class for Store and Update Request
     *
     * @param string $requestPath
     * @return int
     */
    protected function createRequestStubs(string $requestPath): int
    {
        return $this->call('make:request', [
            'name' => $requestPath . 'Request'
        ]);
    }

    /**
     * Create Business Logic handle Services for Repository
     *
     * @param $servicePath
     * @return int
     */
    protected function createServiceStubs($servicePath): int
    {
        return $this->call('create:service', [
            'name' => $servicePath . 'Service'
        ]);
    }

    /**
     * Create DB Wrapper Repository for Every Model
     *
     * @param $repoPath
     * @return int
     */
    protected function createRepositoryStubs($repoPath): int
    {
        return $this->call('create:repository', [
            'name' => $repoPath . 'Repository'
        ]);
    }

    /**
     * Create CRUD Form View Files
     *
     * @param string $viewPath
     * @return int
     */
    protected function createViewStubs(string $viewPath): int
    {
        /*        $templates_dir = storage_path('stubs');
                $target_dir = resource_path('views');*/
        return 0;
    }
}
