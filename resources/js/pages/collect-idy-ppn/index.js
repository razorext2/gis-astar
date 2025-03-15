import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";
import { singleAssign } from "./func/assign";
import { reschedule } from "./func/reschedule";

export async function initCollectIdyPpn() {
  showDatatables();
  deleteData();
  singleAssign();
  reschedule();
}