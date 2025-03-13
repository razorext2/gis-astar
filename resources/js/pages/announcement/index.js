import { addDataHandler, editDataHandler } from "./func/formHandler.js";
import { changeState } from "./func/changeState.js";
import { deleteData } from "./func/delete.js";

export async function initAnnouncement() {
  addDataHandler();
  editDataHandler();
  changeState();
  deleteData();
}
