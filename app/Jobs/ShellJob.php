<?php

namespace App\Jobs;

use App\Models\CommandHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ShellJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $command;
    public $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($command, $path = null)
    {
        $this->command = $command;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->path)
            chdir($this->path);
        $output = shell_exec($this->command);

        CommandHistory::create([
            'command' => $this->command,
            'output' => $output,
        ]);
    }
}
