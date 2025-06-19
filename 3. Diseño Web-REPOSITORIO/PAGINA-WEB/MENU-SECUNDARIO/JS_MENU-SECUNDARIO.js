document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll("nav a");

  navLinks.forEach(link => {
    link.addEventListener("click", function (event) {
      event.preventDefault();

      navLinks.forEach(l => l.classList.remove("active"));

      this.classList.add("active");
    });
  });
});
