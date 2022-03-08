<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\ActivityLogRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{

    /**
     * activityLogRepository
     *
     * @var ActivityLogRepository
     */
    private ActivityLogRepository $activityLogRepository;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->activityLogRepository = new ActivityLogRepository;
        // $this->userRepository        = new UserRepository;
        // $this->fileService           = new FileService;

        // $this->middleware('can:Log Aktivitas');
    }

    /**
     * Menampilkan halaman dashboard
     *
     * @return Response
     */
    public function index()
    {
        $widgets = [];
        $user = auth()->user();
        if ($user->hasRole('superadmin')) {
            $widgets[] = (object)[
                'title' => 'Pengguna',
                'count' => User::count(),
                'bg'    => 'primary',
                'icon'  => 'users',
                'route' => route('user-management.users.index'),
            ];
            $widgets[] = (object)[
                'title' => 'Role',
                'count' => Role::count(),
                'bg'    => 'danger',
                'icon'  => 'users',
                'route' => route('user-management.roles.index')
            ];
            $widgets[] = (object)[
                'title' => 'Log Aktivitas',
                'count' => ActivityLog::count(),
                'bg'    => 'success',
                'icon'  => 'clock-rotate-left',
                'route' => route('activity-logs.index')
            ];
        }
        if ($user->can('Notifikasi'))
            $widgets[] = (object)[
                'title' => 'Notifikasi',
                'count' => Notification::where('user_id', $user->id)->count(),
                'bg'    => 'info',
                'icon'  => 'bell',
                'route' => route('notifications.index'),
            ];

        $logs = $this->activityLogRepository->getMineLatest();

        return view('stisla.dashboard.index', [
            'widgets' => $widgets,
            'logs'    => $logs,
        ]);
    }
}
