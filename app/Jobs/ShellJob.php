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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $output = shell_exec($this->command);

        CommandHistory::create([
            'command' => $this->command,
            'output' => $output,
        ]);
    }
}
