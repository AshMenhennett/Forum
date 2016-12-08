<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Topic;
use App\Report;
use Illuminate\Http\Request;

class ModeratorDashboardController extends Controller
{

    /**
     * Returns all valid reports.
     * Used by index (Request $request)
     *
     * @return Illuminate\Http\Response
     */
    protected function getReports ()
    {
        return Report::where('content_id', '!=', '-1')->orderBy('created_at', 'asc')->get();
    }

    /**
     * Returns all admin users. Used to display their
     * contact details to moderators.
     *
     * Used by index (Request $request)
     *
     * @return Illuminate\Http\Response
     */
    protected function getAdminUsers ()
    {
        return User::where('role', 'admin')->get();
    }

    /**
     * Displays moderator dashboard.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        return view('moderator.dashboard.index', [
            'reports' => $this->getReports(),
            'admins' => $this->getAdminUsers(),
        ]);
    }

    /**
     * Deletes a Report.
     * Used by ModeratorDeleteReportButtonComponent Vue component.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Report               $report
     * @return Illuminate\Http\Response
     */
    public function destroy(Request $request, Report $report)
    {
        $report->delete();

        return response()->json(null, 200);
    }

}
