<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Attendance;
use App\Models\Post;
use App\Models\User;
use App\Http\Controllers\AttendanceReportController;
use Illuminate\Support\Facades\URL;

class ReportExport implements FromView
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;

        
    }

    public function view(): View
    {
        // dd($this->data);
        return view('reports.xml', [
            'data' => $this->data
        ]);
    }
}
