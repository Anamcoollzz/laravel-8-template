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

    public function laravelMigrate($pathnameD)
    {
        $commands = [];
        $commands[] = 'cd ' . $pathnameD;
        $commands[] = 'php artisan migrate';

        $command = implode(' && ', $commands);

        return $command;
    }

    public function laravelMigrateRefresh($pathnameD)
    {
        $commands = [];
        // $commands[] = 'cd ' . $pathnameD;
        $commands[] = 'php ' . $pathnameD . '/artisan migrate:refresh';

        $command = implode(' && ', $commands);

        return $command;
    }

    public function laravelDbSeed($pathnameD, $class)
    {
        $commands = [];
        $commands[] = 'cd ' . $pathnameD;
        if ($class === 'all') {
            $commands[] = 'php artisan db:seed';
        } else {
            $commands[] = 'php artisan db:seed --class=' . $class;
        }

        $command = implode(' && ', $commands);

        return $command;
    }

    public function supervisor($action)
    {
        if (!in_array($action, ['start', 'stop', 'restart', 'reload', 'status', 'update', 'reread'])) {
            abort(404);
        }
        if ($action === 'update') {
            return 'supervisorctl update';
        } else if ($action === 'reread') {
            return 'supervisorctl reread';
        }
        $command = "service supervisor " . $action;
        return $command;
    }

    public function phpFpm($version, $action)
    {
        if (!in_array($action, ['start', 'stop', 'restart', 'reload', 'status'])) {
            abort(404);
        }
        $command = "service php" . $version . "-fpm " . $action;
        return $command;
    }

    public function mysql($action)
    {
        if (!in_array($action, ['start', 'stop', 'restart', 'reload', 'status'])) {
            abort(404);
        }
        $command = "service mysql " . $action;
        return $command;
    }

    public function nginx($action)
    {
        if (!in_array($action, ['start', 'stop', 'restart', 'reload', 'status'])) {
            abort(404);
        }
        $command = "service nginx " . $action;
        return $command;
    }

    public function enableNginxConf($path)
    {
        return 'ln -s ' . $path . ' /etc/nginx/sites-enabled/';
    }

    public function sslNginx($domain)
    {
        return 'certbot --nginx -d ' . $domain;
    }

    public function deleteSSL($domain)
    {
        return 'certbot delete --cert-name ' . $domain;
    }

    public function sslApache($domain)
    {
        return 'certbot --apache -d ' . $domain;
    }

    public function disableNginxConf($path)
    {
        $paths = explode('/', $path);
        return 'rm /etc/nginx/sites-enabled/' . end($paths);
    }

    public function deleteFile($path)
    {
        return 'rm ' . $path;
    }
}
