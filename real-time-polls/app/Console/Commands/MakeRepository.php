<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : the repository class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';


    public function getStub()
    {
        return $this->resolveStubPath('/Stubs/repository.stub');
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
        return $rootNamespace.'\Repositories';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository.'],
        ];
    }

    public function rootNamespace()
    {
        return 'App';
    }
}
