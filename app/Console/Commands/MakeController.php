<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller {name} {entity} {--resource : Create a resource controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the controller name and entity from the arguments
        $name = $this->argument('name');
        $entity = $this->argument('entity');

        // Check if entity is provided
        if (empty($entity)) {
            $this->error('The entity argument is required.');
            return;
        }

        // Check if the entity is allowed
        $allowedEntities = config('entities.allowed');
        if (!in_array($entity, $allowedEntities)) {
            $this->error("The entity '{$entity}' is not allowed.");
            return;
        }

        // Determine the stub file based on the resource option
        $stub = $this->getStub();

        // Replace placeholders in the stub
        $stub = $this->replacePlaceholders($stub, $name, $entity);

        // Define the path for the new controller
        $directory = base_path("application/{$entity}");
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $path = "{$directory}/{$name}Controller.php";

        // Save the generated controller to the file path
        file_put_contents($path, $stub);
        $this->info("Controller {$name} created successfully at {$path}");
    }

    // Determine which stub to use based on the resource option
    protected function getStub()
    {
        return $this->option('resource')
            ? base_path('stubs/CustomController/resource.stub')
            : base_path('stubs/CustomController/default.stub');
    }

    // Replace placeholders in the stub
    protected function replacePlaceholders($stub, $name, $entity)
    {
        // Replace the {{ class }} and {{ namespace }} placeholders
        $namespace = "Application\\{$entity}";
        $stub = str_replace('{{ class }}', "{$name}Controller", $stub);
        $stub = str_replace('{{ namespace }}', $namespace, $stub);
        return $stub;
    }
}
