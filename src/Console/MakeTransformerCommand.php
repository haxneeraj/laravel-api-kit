<?php

namespace Haxneeraj\LaravelAPIKit\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeTransformerCommand extends Command
{
    protected $signature = 'make:transformer {name : The name of the transformer class}';

    protected $description = 'Create a new transformer class';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('name');

        // Convert slashes to match the directory separator (handles Test/Test format)
        $classPath = str_replace('\\', '/', $name);

        // Define the destination path for the new Transformer class
        $destinationPath = app_path('Transformers/' . $classPath . '.php');

        // Get the directory from the destination path
        $directory = dirname($destinationPath);

        // Ensure the directory exists, create it if it doesn't
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true); // Recursive directory creation
        }

        // Check if the transformer already exists
        if ($this->files->exists($destinationPath)) {
            $this->error('Transformer already exists!');
            return 1;
        }

        // Define the stub file path
        $stubPath = __DIR__ . '/../../stubs/transformer.stub';

        // Check if the stub file exists
        if (!$this->files->exists($stubPath)) {
            $this->error('Stub file not found.');
            return 1;
        }

        // Read the stub file content
        $stub = $this->files->get($stubPath);

        // Get the class name from the full name (handle nested class)
        $className = basename($name);

        // Replace the class placeholder with the actual class name
        $stub = str_replace('{{ class }}', $className, $stub);

        // Write the new transformer class file
        $this->files->put($destinationPath, $stub);

        $this->info('Transformer created successfully at ' . $destinationPath);
        return 0;
    }
}
