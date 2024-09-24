<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModel extends Command
{
    // Command signature with optional arguments and options for migration, controller, factory, and resource
    protected $signature = 'make:model {name} {auth?} {entity?} {--m|migration : Create a migration file for the model} {--c|controller : Create a controller for the model} {--f|factory : Create a factory for the model} {--r|resource : Create a resource controller for the model}';

    protected $description = 'Create a new Eloquent model with optional authentication logic and additional files.';

    // Define the path to your custom stub
    protected function getStub($auth)
    {
        if ($auth === 'auth') {
            return base_path('stubs/CustomModels/auth.stub');
        }
        return base_path('stubs/CustomModels/default.stub');
    }

    public function handle()
    {
        // Get the 'name' argument for the model name
        $name = ucfirst($this->argument('name'));
        // Get the 'entity' argument
        $entity = ucfirst($this->argument('entity'));
        // Get the 'auth' argument (optional)
        $auth = $this->argument('auth');

        // Ensure the directory for models exists, creating it if necessary
        $directory = base_path('laravel/Model');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true); // Create directory if it doesn't exist
        }

        // Get the content of the stub file
        $stub = file_get_contents($this->getStub($auth));

        // Replace the placeholders in the stub
        $stub = $this->replacePlaceholders($stub, $name, $auth);

        // Determine the file path for the new model
        $path = "{$directory}/{$name}.php";

        // Save the generated model to the file path
        file_put_contents($path, $stub);
        $this->info("Model {$name} generated successfully at {$path}");

        // Handle migration creation if the option is provided
        if ($this->option('migration')) {
            $this->call('make:migration', ['name' => Str::plural($name)]); // Use plural for migration
        }

        // Handle factory creation if the option is provided
        if ($this->option('factory')) {
            $this->call('make:factory', ['name' => $name]);
        }

        // Handle controller creation if the option is provided
        if ($this->option('controller') || $this->option('resource')) {
            // Validate the entity against allowed entities in config
            $allowedEntities = config('entities.allowed');
            if (!in_array($entity, $allowedEntities)) {
                $this->error("The entity '{$entity}' is not allowed. Allowed entities are: " . implode(', ', $allowedEntities));
                return; // Exit the command
            }

            $controllerOptions = [];
            if ($this->option('resource')) {
                $controllerOptions['--resource'] = true;
            }
            $this->call('make:controller', array_merge($controllerOptions, [
                'name' => "{$name}Controller",
                'entity' => $entity
            ]));
        }
    }

    // Replace placeholders in the stub
    protected function replacePlaceholders($stub, $name, $auth)
    {
        // Replace the {{ class }} placeholder with the model name
        $stub = str_replace('{{ class }}', $name, $stub);

        // Handle the 'auth' argument for both use statements and method implementations
        if ($auth === 'auth') {
            $authImport = "use Illuminate\Contracts\Auth\Authenticatable;\n";
            $authTrait = 'implements Authenticatable';
            $stub = str_replace('{{ authenticatable }}', $authImport, $stub);
            $stub = str_replace('{{ implements }}', $authTrait, $stub);
        }

        // Return the modified stub content
        return $stub;
    }
}
