<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeModelData extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:modeldata {name : the model data class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model data class';

    protected $type = 'ModelData';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function getStub()
    {
        return $this->resolveStubPath('/Stubs/modeldata.stub');
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
            ['name', InputArgument::REQUIRED, 'The name of the model data.'],
        ];
    }

    public function rootNamespace()
    {
        return 'App';
    }
}
