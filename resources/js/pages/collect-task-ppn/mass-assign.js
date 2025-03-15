import { searchPegawaiHandler, searchSRHandler } from "./func/mass-search";
import { massAssign } from "./func/assign";

document.addEventListener("DOMContentLoaded", function () {
  searchPegawaiHandler();
  searchSRHandler();
  massAssign();
})