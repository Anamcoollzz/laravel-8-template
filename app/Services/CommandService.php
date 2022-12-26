<?php

namespace App\Services;

class CommandService
{

    public function setLaravelPermission($pathnameD)
    {
        $commands = [];
        $commands[] = 'cd ' . $pathnameD;
        $commands[] = 'sudo chown -R www-data:www-data ' . $pathnameD;
        $commands[] = 'sudo usermod -a -G www-data root';
        $commands[] = 'sudo find ' . $pathnameD . ' -type f -exec chmod 644 {} \;';
        $commands[] = 'sudo find ' . $pathnameD . ' -type d -exec chmod 755 {} \;';
        $commands[] = 'sudo chmod -R ug+rwx ' . $pathnameD . '/storage';
        $commands[] = 'sudo chmod -R ug+rwx ' . $pathnameD . '/bootstrap/cache';

        $command = implode(' && ', $commands);

        return $command;
    }
}
