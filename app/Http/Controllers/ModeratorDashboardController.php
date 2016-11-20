<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Topic;
use App\Report;
use Illuminate\Http\Request;

class ModeratorDashboardController extends Controller
{

    protected function getReports()
    {
        return Report::where('content_id', '!=', '-1')->orderBy('created_at', 'asc')->get();
    }

    protected function getAdminUsers()
    {
        return User::where('role', 'admin')->get();
    }

    public function index(Request $request)
    {
        return view('moderator.dashboard.index', [
            'reports' => $this->getReports(),
            'admins' => $this->getAdminUsers(),
        ]);
    }

    public function destroy(Request $request, Report $report)
    {
        $report->delete();

        return response()->json(null, 200);
    }

}
