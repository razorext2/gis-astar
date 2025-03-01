const preloader = document.querySelector("#preloader");
const themeToggleDarkBtn = document.getElementById("theme-toggle-dark");
const themeToggleLightBtn = document.getElementById("theme-toggle-light");

function scrollContent(e) {
  scrollContainer.scrollBy({
    left: 300 * e,
    behavior: "smooth"
  })
}

function toggleTheme(e) {
  document.documentElement.classList.toggle("dark", e), localStorage.setItem("color-theme", e ? "dark" : "light"),
    themeToggleDarkBtn.classList.toggle("text-gray-300", e), themeToggleDarkBtn.classList.toggle("text-gray-200", !
      e), themeToggleLightBtn.classList.toggle("text-gray-700", e), themeToggleLightBtn.classList.toggle(
        "text-red-400", !e)
}

preloader && document.addEventListener("livewire:navigated", (() => {
  preloader.remove()
}));

document.addEventListener('livewire:navigated', function () {
  const isDarkMode = "dark" === localStorage.getItem("color-theme") || !("color-theme" in localStorage) && window
    .matchMedia("(prefers-color-scheme: dark)").matches;
  toggleTheme(isDarkMode), themeToggleDarkBtn.addEventListener("click", (() => toggleTheme(!0))), themeToggleLightBtn
    .addEventListener("click", (() => toggleTheme(!1)));
})