import { quillEditor } from "./func/quillEditor";
import { editDataHandler } from "./func/formHandler";

document.addEventListener("livewire:navigated", function () {
  quillEditor(data, true);
  editDataHandler();
})