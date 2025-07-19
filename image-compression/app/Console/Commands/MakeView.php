<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeView extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {name : the view class name}
    {--list : create a list view}
    {--create : create a create view}
    {--edit : create a edit view}
    {--show : create a show view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view class';

    protected $type = 'Views';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function getStub()
    {
        if ($this->option('create')) {
            return $this->resolveStubPath('/Stubs/Views/create.stub');
        } elseif ($this->option('edit')) {
            return $this->resolveStubPath('/Stubs/Views/edit.stub');
        } elseif ($this->option('show')) {
            return $this->resolveStubPath('/Stubs/Views/show.stub');
        } else {
            return $this->resolveStubPath('/Stubs/Views/list.stub');
        }
    }

    public function resolveStubPath($stub){
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/'))) ? $customPath : __DIR__.$stub;
    }

    public function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNameSpace(), '',$name);
        return base_path('resources/views').str_replace('\\','/', $name).'.blade.php';
    }

    public function getDefaultNameSpace($rootNamespace)
    {
        return $rootNamespace;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the service.'],
        ];
    }

    public function rootNamespace()
    {
        return 'Resources';
    }
}
