import { getAttendanceData } from "./func/getAttendanceData";
import { getAttendancePeriod } from "./func/getAttendancePeriod";

document.addEventListener('DOMContentLoaded', () => {
  getAttendanceData();
  getAttendancePeriod();
});