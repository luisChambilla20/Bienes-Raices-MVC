document.addEventListener("DOMContentLoaded", function () {
  eventListeners();

  darkMode();
});

function darkMode() {
  const prefiereDarkMode = window.matchMedia("(prefers-color-scheme: dark)");

  // console.log(prefiereDarkMode.matches);

  if (prefiereDarkMode.matches) {
    document.body.classList.add("dark-mode");
  } else {
    document.body.classList.remove("dark-mode");
  }

  prefiereDarkMode.addEventListener("change", function () {
    if (prefiereDarkMode.matches) {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
  });

  const botonDarkMode = document.querySelector(".dark-mode-boton");
  botonDarkMode.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
  });
}

function eventListeners() {
  const mobileMenu = document.querySelector(".mobile-menu");

  mobileMenu.addEventListener("click", navegacionResponsive);

  //EVENTOS QUE MUESTRA Y OCULTA ALGO
  const contacto = document.querySelectorAll('input[name="contacto[metodo]"]');
  contacto.forEach((input) => input.addEventListener("click", mostrarEvento));
}

function navegacionResponsive() {
  const navegacion = document.querySelector(".navegacion");

  navegacion.classList.toggle("mostrar");
}

function mostrarEvento(e) {
  const metodo = document.querySelector("#metodo-contactar");
  if (e.target.value === "email") {
    metodo.innerHTML = `
    <br>
    <label for="email">E-mail</label>
    <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" required>
    `;
  } else {
    metodo.innerHTML = `
    <br>
    <label for="telefono">Teléfono</label>
    <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">

    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="contacto[fecha]">

    <label for="hora">Hora:</label>
    <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
    `;
  }
}
