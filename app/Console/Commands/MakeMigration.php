<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MakeMigration extends Command
{
    protected $signature = 'make:migration {name} {--type= : Specify migration type (create or add)} {--auth : Use auth stub for table creation}';
    protected $description = 'Create a new migration file, either for creating a table or adding columns';

    public function handle()
    {
        $name = $this->argument('name');
        $type = $this->option('type') ?? 'create';  // Default to "create" if no type is specified

        if ($type === 'add') {
            // Handle logic for adding columns to an existing table
            $this->createAddColumnMigration($name);
        } else {
            // Default to table creation logic (handle --auth option here)
            $this->createTableMigration($name);
        }
    }

    /**
     * Generate migration for adding columns to an existing table.
     */
    protected function createAddColumnMigration($name)
    {
        // Generate the migration file name for adding columns
        $migrationFileName = $this->generateMigrationFileName($name, 'add');
        $migrationPath = database_path('migrations');

        // Load the 'add' stub for adding columns
        $stub = file_get_contents(base_path('stubs/CustomMigration/add.stub'));

        // Replace placeholders in the stub with relevant class and table names
        $stub = $this->replacePlaceholders($stub, $name, 'add');

        // Write the migration file to the migrations directory
        File::put("{$migrationPath}/{$migrationFileName}", $stub);

        $this->info("Add columns migration created successfully: {$migrationFileName}");
    }

    /**
     * Generate migration for creating a new table.
     */
    protected function createTableMigration($name)
    {
        // Generate the migration file name for creating a table
        $migrationFileName = $this->generateMigrationFileName($name, 'create');
        $migrationPath = database_path('migrations');

        // Use the appropriate stub based on the --auth option
        $stub = $this->getCreateStub();

        // Replace placeholders in the stub with relevant class and table names
        $stub = $this->replacePlaceholders($stub, $name, 'create');

        // Write the migration file
        File::put("{$migrationPath}/{$migrationFileName}", $stub);

        $this->info("Table creation migration created successfully: {$migrationFileName}");
    }

    /**
     * Generate the migration file name based on the type (create or add).
     */
    protected function generateMigrationFileName($name, $type)
    {
        $pluralName = Str::plural($name);
        $timestamp = date('Y_m_d_His');
        
        if ($type === 'add') {
            return "{$timestamp}_add_columns_to_" . Str::snake($pluralName) . '.php';
        }

        // Default to 'create' migration file name
        return "{$timestamp}_create_" . Str::snake($pluralName) . '.php';
    }

    /**
     * Replace placeholders in the stub file.
     */
    protected function replacePlaceholders($stub, $name, $type)
    {
        $className = ($type === 'add') 
            ? 'AddColumnsTo' . Str::pluralStudly($name) 
            : 'Create' . Str::pluralStudly($name);

        $stub = str_replace('{{ class }}', $className, $stub);

        // Use plural form for the table name
        $tableName = Str::snake(Str::plural($name));
        $stub = str_replace('{{ table }}', $tableName, $stub);

        return $stub;
    }

    /**
     * Get the appropriate stub for table creation based on --auth option.
     */
    protected function getCreateStub()
    {
        if ($this->option('auth')) {
            return file_get_contents(base_path('stubs/CustomMigration/auth.stub'));
        }
        return file_get_contents(base_path('stubs/CustomMigration/default.stub'));
    }
}
