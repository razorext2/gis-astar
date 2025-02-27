import { fetchDataHandler } from "./func/fetchData";
import { submitHandler } from "./func/submitHandler";

document.addEventListener('livewire:navigated', function () {
  fetchDataHandler();
  submitHandler();
})