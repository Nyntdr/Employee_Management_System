<?php

namespace App\Http\Controllers;

use App\Enums\AssetTypes;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Event;
use App\Models\Leave;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\IpUtils;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalUsers = User::count();
        $totalDepartments = Department::count();
        $totalEmployees = Employee::count();
        $totalNotices = Notice::count();
        $totalAssets = Asset::count();
        $totalEvents = Event::count();
        $totalLeaves = Leave::count();
        $totalAssetAssignments = AssetAssignment::count();
        $employeesByDepartment = Department::withCount('employees')->get();

        // Get assets count by type
        $assetTypes = AssetTypes::cases();
        $assetsByType = [];
        $assetTypeLabels = [];

        foreach ($assetTypes as $type) {
            $count = Asset::where('type', $type->value)->count();
            $assetsByType[] = $count;
            $assetTypeLabels[] = ucfirst($type->value);
        }

        return view('admin.dashboards.admin_dashboard', compact(
            'totalUsers',
            'totalDepartments',
            'totalEmployees',
            'totalEvents',
            'totalNotices',
            'totalAssets',
            'totalLeaves',
            'totalAssetAssignments',
            'employeesByDepartment',
            'assetsByType',
            'assetTypeLabels'
        ));
    }

    private $officeIp = ['110.34.27.186', '127.0.0.1'];

    public function employeeDashboard(Request $request)
    {
        $ip = $request->getClientIp();
        // if (app()->environment('local')) {
        //     $ip = '110.34.27.186';
        // }
        $isAllowed = IpUtils::checkIp($ip, $this->officeIp);

        $totalAssets = AssetAssignment::where('employee_id', Auth::user()->employee->employee_id)->count();
        $totalLeaves = Leave::where('employee_id', Auth::user()->employee->employee_id)->count();
        $totalNotices = Notice::count();
        $latestNotice = Notice::latest()->first();
        $totalEvents = Event::count();
        $latestEvent = Event::where(function ($query) {
            $query->where('start_time', '>=', now())
                ->orWhere('end_time', '>=', now());
        })
            ->orderBy('start_time')
            ->first();

        return view('employee.dashboard.dashboard', compact(
            'totalAssets',
            'totalLeaves',
            'ip',
            'isAllowed',
            'totalNotices',
            'latestNotice',
            'totalEvents',
            'latestEvent'
        ));
    }
}
