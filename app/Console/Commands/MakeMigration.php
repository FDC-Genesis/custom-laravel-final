<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MakeMigration extends Command
{
    protected $signature = 'make:migration {name}  {--auth : Add Columns}';
    protected $description = 'Create a new migration file with a given name';

    public function handle()
    {
        $name = $this->argument('name');

        // Generate the migration file name using the pluralized version
        $migrationFileName = $this->generateMigrationFileName($name);
        $migrationPath = database_path('migrations');

        // Get the stub content
        $stub = $this->getStub();

        // Replace placeholders in the stub
        $stub = $this->replacePlaceholders($stub, $name);

        // Write the migration file
        File::put("{$migrationPath}/{$migrationFileName}", $stub);

        $this->info("Migration created successfully: {$migrationFileName}");
    }

    protected function generateMigrationFileName($name)
    {
        // Generate the pluralized version of the name
        $pluralName = Str::plural($name);
        return date('Y_m_d_His') . '_' . Str::snake($pluralName) . '.php';
    }

    protected function getStub()
    {
        if ($this->option('auth')){
            return file_get_contents(base_path('stubs/CustomMigration/auth.stub'));
        }
        return file_get_contents(base_path('stubs/CustomMigration/default.stub'));
    }

    protected function replacePlaceholders($stub, $name)
    {
        $className = Str::studly($name);
        $stub = str_replace('{{ class }}', $className, $stub);

        // Use plural form for the table name
        $tableName = Str::snake(Str::plural($name));
        $stub = str_replace('{{ table }}', $tableName, $stub);

        return $stub;
    }
}
