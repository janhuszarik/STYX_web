
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
$(document).ready(function () {
  $('#summernote').summernote({
    height: 300,
    placeholder: 'Text hier eingeben...',
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['codeview']]
    ]
  });

  // pri odoslaní formulára vloží obsah editoru do hidden inputu
  $('form').on('submit', function () {
    $('#text').val($('#summernote').summernote('code'));
  });
});
