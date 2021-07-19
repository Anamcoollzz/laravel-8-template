<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make service';

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
        $name = $this->ask('Service name? (without Service suffix)');
        if (!$name)
            $this->error('Name required!');
        else {
            $serviceFile = file_get_contents(app_path('Console/Commands/data/NameService.php.dummy'));
            $serviceFile = str_replace('NameService', $name . 'Service', $serviceFile);
            if ($this->confirm('Do you wish to continue? (' . $name . 'Service)')) {
                $filepath = app_path('Services\\' . $name . 'Service.php');
                if (file_exists($filepath)) {
                    if ($this->confirm('File is exist, do you want to replace?')) {
                        file_put_contents($filepath, $serviceFile);
                        $this->info($name . 'Service.php has been created in ' . $filepath);
                    } else {
                        $this->info('Canceled!');
                    }
                } else {
                    file_put_contents($filepath, $serviceFile);
                    $this->info($name . 'Service.php has been created in ' . $filepath);
                }
            } else {
                $this->info('Canceled!');
            }
            return 0;
        }
    }
}
