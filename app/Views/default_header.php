<!DOCTYPE html>
<html id="goFullScreen">

<head>
  <title>Kaipekalodge - Gestion Réservation</title>
  <?php if(env('CI_ENVIRONMENT') == 'development' ){?>
    <link href="Assets/css/wd_composed_style.css" rel="stylesheet">
    <link href="Assets/css/select2.min.css" rel="stylesheet">
    <link href="Assets/css/wd_datepicker.css" rel="stylesheet">
    <?php } else { ?>
      <link href="Assets/css/all/all.min.css" rel="stylesheet">
  <?php } ?>
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <!-- Responsive design : system css viewport et utilisation des unités vh et vw) -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="preload">
    <!-- DARK MODE SWITCH -->
    <div class="container-darkmode bg-white dark:bg-black shadow-xl border-2 border-slate-300 dark:border-slate-800">
    <label class="relative inline-flex items-center mb-5 cursor-pointer">
      <input type="checkbox" id="toggleDarkMode" value="" class="sr-only peer">
      <div class="w-10 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-900 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-800"></div>
      <span id="label_darkmode" class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 break-words"></span>
    </label>
  </div>
  <script>
  // Définitions des icônes SVG pour le soleil et la lune
  const svgSun = `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3V1m0 18v-2M5.05 5.05 3.636 3.636m12.728 12.728L14.95 14.95M3 10H1m18 0h-2M5.05 14.95l-1.414 1.414M16.364 3.636 14.95 5.05M14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/></svg>`;
  const svgMoon = `<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.509 5.75c0-1.493.394-2.96 1.144-4.25h-.081a8.5 8.5 0 1 0 7.356 12.746A8.5 8.5 0 0 1 8.509 5.75Z"/></svg>`;

  // Fonctions pour la gestion des cookies
  function setCookie(name, value, days) {
    var expires = '';
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = '; expires=' + date.toUTCString();
    }
    document.cookie = name + '=' + (value || '') + expires + '; path=/';
  }

  function getCookie(name) {
    var nameEQ = name + '=';
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }

  // Initialisation et écouteur d'événement pour le toggle du mode sombre
  document.addEventListener('DOMContentLoaded', () => {
    const toggleDarkMode = document.getElementById('toggleDarkMode');
    const labelDarkmode = document.getElementById('label_darkmode');
    let isDarkMode = getCookie('darkMode') === '1';

    const updateIcon = () => {
      labelDarkmode.innerHTML = isDarkMode ? svgMoon : svgSun;
    };

    if (isDarkMode) {
      document.body.classList.add('dark');
      toggleDarkMode.checked = true;
    }
    updateIcon();

    toggleDarkMode.addEventListener('change', function() {
      isDarkMode = !isDarkMode;
      document.body.classList.toggle('dark', isDarkMode);
      setCookie('darkMode', isDarkMode ? '1' : '0', 365);
      updateIcon();
    });

    document.body.classList.remove('preload');
  });
</script>

  
  <script src="Assets/js/easepick.js"></script>
    <!-- LOADER PAGE FOR LOADING PAGE -->
  <div class="loader"></div>

  <div class="flex flex-col h-screen w-full justify-center items-center text-gray-900 dark:text-white bg-slate-50 dark:bg-slate-900">

