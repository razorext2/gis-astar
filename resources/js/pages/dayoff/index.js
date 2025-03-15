import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";

export async function initDayoff() {
  showDatatables();
  deleteData();
}