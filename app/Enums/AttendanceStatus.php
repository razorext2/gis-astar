<?php

/** Goal: Enum status absensi — menggantikan magic number 0/1/2, Caller: ProcessFaceRecognition, Models, Deps: - */

namespace App\Enums;

enum AttendanceStatus: int
{
    case Pending = 0;
    case Verified = 1;
    case Failed = 2;
}
