$(document).ready(function () {
  const $preloader = $("#preloader");
  $preloader.length && $(window).on("load", () => {
    $preloader.remove();
  });

  const $scrollContainer = $("#scrollContainer");
  const $nextButton = $("#nextButton");
  const $prevButton = $("#prevButton");

  function scrollContent(direction) {
    $scrollContainer.animate({
      scrollLeft: '+=' + (300 * direction)
    }, 'smooth');
  }

  function updateButtonVisibility() {
    const isOverflowing = $scrollContainer[0].scrollWidth > $scrollContainer.width();
    $nextButton.toggle(isOverflowing);
    $prevButton.toggle(isOverflowing);
  }

  $nextButton.on("click", () => scrollContent(1));
  $prevButton.on("click", () => scrollContent(-1));

  updateButtonVisibility();
  $(window).on("resize", updateButtonVisibility);

  const $themeToggleDarkBtn = $("#theme-toggle-dark");
  const $themeToggleLightBtn = $("#theme-toggle-light");

  function toggleTheme(isDark) {
    $("html").toggleClass("dark", isDark);
    localStorage.setItem("color-theme", isDark ? "dark" : "light");
    $themeToggleDarkBtn.toggleClass("text-gray-300", isDark).toggleClass("text-gray-200", !isDark);
    $themeToggleLightBtn.toggleClass("text-gray-700", isDark).toggleClass("text-red-400", !isDark);
  }

  const isDarkMode = localStorage.getItem("color-theme") === "dark" ||
    (!("color-theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches);

  toggleTheme(isDarkMode);
  $themeToggleDarkBtn.on("click", () => toggleTheme(true));
  $themeToggleLightBtn.on("click", () => toggleTheme(false));
});