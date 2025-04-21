<?php

namespace App\Repositories;
use App\Interfaces\AttendanceSheetInterface;
use App\Models\AttendanceSheet;
use App\Models\EntryCode;


class AttendanceSheetRepository implements AttendanceSheetInterface
{

    public function create(array $data): AttendanceSheet
    {
        return AttendanceSheet::create($data);
    }
}
