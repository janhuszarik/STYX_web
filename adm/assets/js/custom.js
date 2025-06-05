
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
  // Summernote init
  $('#summernote').summernote({
    height: 450,
    fontNames: ['Poppins'],
    fontNamesIgnoreCheck: ['Poppins'],
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['codeview']]
    ]
  });


  // Synchronizácia pri submit
  $('form').on('submit', function () {
    $('#text').val($('#summernote').summernote('code'));
  });

  // Načítanie šablón z JSON
  console.log("Načítavam šablóny...");

  fetch(BASE_URL + 'adm/assets/js/article_templates.json')
    .then(res => {
      if (!res.ok) throw new Error('Chyba načítania: ' + res.status);
      return res.json();
    })
    .then(templates => {
      const $picker = $('#templatePicker');
      console.log('Šablóny načítané:', templates);
      templates.forEach(t => {
        $picker.append(
          $('<option>', {
            value: t.content,
            text: t.label
          })
        );
      });
    })
    .catch(err => {
      console.error('Šablóny sa nepodarilo načítať:', err);
    });



  // Po výbere šablóny vlož do editora
  $('#templatePicker').on('change', function () {
    const html = $(this).val();
    if (html) $('#summernote').summernote('code', html);
  });

  // Výmena obrázkov kliknutím
  $('#summernote').on('click', 'img', function () {
    const img = this;
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function (e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (evt) {
          $(img).attr('src', evt.target.result);
        };
        reader.readAsDataURL(file);
      }
    };
    input.click();
  });
});

$('#templatePicker').on('change', function () {
  const template = $(this).val();
  if (template) {
    $('#summernote').summernote('code', template);
  }
});
