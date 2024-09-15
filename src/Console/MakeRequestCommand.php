<?php

namespace Haxneeraj\LaravelAPIKit\Console;

use Illuminate\Foundation\Console\RequestMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeRequestCommand extends RequestMakeCommand
{
    protected $signature = 'make:request {name : The name of the request class}';

    protected $description = 'Create a new form request class with custom logic';

    public function handle()
    {
        $name = $this->argument('name');
        parent::handle();
        $this->info("Custom request $name has been created successfully.");
    }

    protected function getStub()
    {
        return __DIR__.'/../../stubs/request.stub';
    }

    protected function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['custom', null, InputOption::VALUE_NONE, 'Use the custom request stub'],
            ]
        );
    }
}
