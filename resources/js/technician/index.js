import { showData } from "./func/showData";

document.addEventListener('livewire:navigated', function () {
  showData();
})