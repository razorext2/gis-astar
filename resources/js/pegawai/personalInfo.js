import { getAttendanceData } from "./func/getAttendanceData";
import { getAttendancePeriod } from "./func/getAttendancePeriod";

$(document).ready(function () {
  getAttendanceData();
  getAttendancePeriod();
});