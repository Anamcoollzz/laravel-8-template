<?php

use App\Models\ActivityLog;
use App\Repositories\SettingRepository;

function active_template()
{
    return config('app.template');
}

function is_stisla_template()
{
    return active_template() === 'stisla';
}

/**
 * logLogout
 *
 * @return ActivityLog
 */
function logLogout()
{
    return ActivityLog::create([
        'title'         => __('Keluar'),
        'user_id'       => auth()->id(),
        'role_id'       => auth()->user()->roles[0]['id'],
        'request_data'  => json_encode(request()->all()),
        'before'        => null,
        'activity_type' => LOGOUT,
        'after'         => null,
        'ip'            => request()->ip(),
        'user_agent'    => request()->header('User-Agent'),
    ]);
}

/**
 * logLogin
 *
 * @return ActivityLog
 */
function logLogin()
{
    return ActivityLog::create([
        'title'         => __('Masuk'),
        'user_id'       => auth()->id(),
        'role_id'       => auth()->user()->roles[0]['id'],
        'request_data'  => json_encode(request()->all()),
        'before'        => null,
        'activity_type' => LOGIN,
        'after'         => null,
        'ip'            => request()->ip(),
        'user_agent'    => request()->header('User-Agent'),
    ]);
}

/**
 * logCreate
 *
 * @param string $title
 * @param mixed $after
 * @return ActivityLog
 */
function logCreate(string $title, $after)
{
    return ActivityLog::create([
        'title'         => $title,
        'user_id'       => auth()->id(),
        'role_id'       => auth()->user()->roles[0]['id'],
        'before'        => null,
        'activity_type' => CREATE,
        'request_data'  => json_encode(request()->all()),
        'after'         => is_string($after) ? $after : json_encode($after),
        'ip'            => request()->ip(),
        'user_agent'    => request()->header('User-Agent'),
    ]);
}

/**
 * logUpdate
 *
 * @param mixed $before
 * @param mixed $after
 * @return ActivityLog
 */
function logUpdate(string $title, $before, $after)
{
    return ActivityLog::create([
        'title'         => $title,
        'user_id'       => auth()->id(),
        'role_id'       => auth()->user()->roles[0]['id'],
        'before'        => is_string($before) ? $before : json_encode($before),
        'after'         => is_string($after) ? $after : json_encode($after),
        'activity_type' => UPDATE,
        'request_data'  => json_encode(request()->all()),
        'ip'            => request()->ip(),
        'user_agent'    => request()->header('User-Agent'),
    ]);
}

/**
 * logDelete
 *
 * @param mixed $before
 * @return ActivityLog
 */
function logDelete(string $title, $before)
{
    return ActivityLog::create([
        'title'         => $title,
        'user_id'       => auth()->id(),
        'role_id'       => auth()->user()->roles[0]['id'],
        'before'        => is_string($before) ? $before : json_encode($before),
        'activity_type' => DELETE,
        'after'         => null,
        'ip'            => request()->ip(),
        'user_agent'    => request()->header('User-Agent'),
        'request_data'  => json_encode(request()->all()),
    ]);
}

function since()
{
    return SettingRepository::since();
}

function year()
{
    return since();
}

function app_name()
{
    return SettingRepository::appName();
}

function developer_name()
{
    return SettingRepository::developerName();
}

function developer_whatsapp()
{
    return SettingRepository::developerWhatsapp();
}
