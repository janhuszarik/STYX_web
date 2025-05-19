
// Admin Alerty nastavenie
document.addEventListener("DOMContentLoaded", function () {
  const alertEl = document.getElementById('alertik');
  if (alertEl) {
    // Prvotné nastavenie na neviditeľné
    alertEl.style.opacity = '0';
    alertEl.style.transition = 'opacity 0.5s ease-in-out';

    // Po malom oneskorení (aby sa transition aktivoval)
    setTimeout(() => {
      alertEl.style.opacity = '1';
    }, 100); // 100ms postačuje na plynulý nábeh

    // Po 4 sekundách fade-out
    setTimeout(() => {
      alertEl.style.opacity = '0';
      setTimeout(() => {
        alertEl.remove();
      }, 1000);
    }, 4000);
  }
});
// Admin Alerty nastavenie - koniec
