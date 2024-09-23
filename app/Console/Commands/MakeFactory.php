<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeFactory extends Command
{
    protected $signature = 'make:factory {name}';
    protected $description = 'Create a new factory for the given model';

    public function handle()
    {
        // Get the model name
        $name = $this->argument('name');

        // Define the path to the factory file
        $factoryDirectory = base_path("database/factories/Laravel/Model/");
        $factoryPath = "{$factoryDirectory}{$name}Factory.php";

        // Ensure the factory directory exists
        if (!is_dir($factoryDirectory)) {
            mkdir($factoryDirectory, 0755, true); // Create the directory recursively if it doesn't exist
            $this->info("Created directory: {$factoryDirectory}");
        }

        // Get the stub content
        $stub = file_get_contents(base_path('stubs/CustomFactory/default.stub'));

        // Replace placeholders
        $stub = str_replace('{{ name }}', $name, $stub);

        // Save the generated factory
        file_put_contents($factoryPath, $stub);

        $this->info("Factory {$name}Factory created successfully at {$factoryPath}");
    }
}
