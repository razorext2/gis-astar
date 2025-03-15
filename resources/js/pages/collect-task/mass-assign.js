import { searchPegawaiHandler } from "./func/mass-search";
import { searchSRHandler } from "./func/mass-search";
import { massAssign } from "./func/assign";

document.addEventListener("livewire:navigated", function () {
  searchPegawaiHandler();
  searchSRHandler();
  massAssign();
})