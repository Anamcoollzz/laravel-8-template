<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Repository name? (without Repository suffix)');
        if (!$name)
            $this->error('Name required!');
        else {
            $modelName = $this->ask('Model name? [' . $name . ']');
            if (!$modelName) {
                $modelName = $name;
            }
            $repositoryFile = file_get_contents(app_path('Console/Commands/data/NameRepository.php.dummy'));
            $repositoryFile = str_replace('ModelName', $modelName, $repositoryFile);
            $repositoryFile = str_replace('NameRepository', $name . 'Repository', $repositoryFile);
            if ($this->confirm('Do you wish to continue? (' . $name . 'Repository)')) {
                $filepath = app_path('Repositories\\' . $name . 'Repository.php');
                if (file_exists($filepath)) {
                    if ($this->confirm('File is exist, do you want to replace?')) {
                        file_put_contents($filepath, $repositoryFile);
                        $this->info($name . 'Repository.php has been created in ' . $filepath);
                    } else {
                        $this->info('Canceled!');
                    }
                } else {
                    file_put_contents($filepath, $repositoryFile);
                    $this->info($name . 'Repository.php has been created in ' . $filepath);
                }
            } else {
                $this->info('Canceled!');
            }
            return 0;
        }
    }
}
