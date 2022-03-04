<?php

use App\Models\ActivityLog;
use App\Repositories\SettingRepository;
use Illuminate\Http\JsonResponse;

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
    $user = auth()->user() ?? auth('api')->user();
    return ActivityLog::create([
        'title'         => __('Masuk'),
        'user_id'       => $user->id,
        'role_id'       => $user->roles[0]['id'],
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
    $user = auth()->user() ?? auth('api')->user();
    return ActivityLog::create([
        'title'         => $title,
        'user_id'       => $user->id,
        'role_id'       => $user->roles[0]['id'],
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
    $user = auth()->user() ?? auth('api')->user();
    return ActivityLog::create([
        'title'         => $title,
        'user_id'       => $user->id,
        'role_id'       => $user->roles[0]['id'],
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
    $user = auth()->user() ?? auth('api')->user();
    return ActivityLog::create([
        'title'         => $title,
        'user_id'       => $user->id,
        'role_id'       => $user->roles[0]['id'],
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

/**
 * response422
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response422($errors, string $message = null)
{
    if ($message === null) $message = __('Form tidak valid');
    return response()->json([
        'errors' => $errors,
        'message' => $message,
    ], 422);
}

/**
 * response200
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response200($data = null, string $message = null)
{
    if ($message === null) $message = __('Sukses');
    return response()->json([
        'data' => $data,
        'message' => $message,
    ], 200);
}

/**
 * response404
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response404($data = null, string $message = null)
{
    if ($message === null) $message = __('Data tidak ditemukan.');
    return response()->json([
        'data' => $data,
        'message' => $message,
    ], 404);
}

/**
 * response200
 *
 * @param mixed $errors
 * @param string $message
 * @return JsonResponse
 */
function response500($data = null, string $message = null)
{
    if ($message === null) $message = __('Server Error');
    return response()->json([
        'data' => $data,
        'message' => $message,
    ], 500);
}
