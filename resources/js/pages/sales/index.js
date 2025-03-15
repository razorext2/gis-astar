import { showData, confirmData } from "./func/showData";
import { deleteData } from "./func/delete";

export async function initSales() {
  showData();
  deleteData();
  confirmData();
}