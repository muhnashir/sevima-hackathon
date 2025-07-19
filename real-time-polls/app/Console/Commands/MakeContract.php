<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeContract extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contract {name : the contract class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract class';

    protected $type = 'Contracts';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function getStub()
    {
        return $this->resolveStubPath('/Stubs/contract.stub');
    }

    public function resolveStubPath($stub){
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/'))) ? $customPath : __DIR__.$stub;
    }

    public function getPath($name)
    {

        $name = Str::replaceFirst($this->rootNameSpace(), '',$name);
        return base_path('app').str_replace('\\','/', $name).'.php';
    }

    public function getDefaultNameSpace($rootNamespace)
    {
        return $rootNamespace.'\Contracts';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the contract.'],
        ];
    }

    public function rootNamespace()
    {
        return 'App';
    }
}
