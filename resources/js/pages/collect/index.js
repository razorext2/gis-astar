import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";
import { exportHandler } from "./func/exportLaporan";

export async function initCollect() {
  showDatatables();
  deleteData();
  exportHandler();
}