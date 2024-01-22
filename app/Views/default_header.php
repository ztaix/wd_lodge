<!DOCTYPE html>
<html id="goFullScreen">

<head>
  <title>Kaipekalodge - Gestion Réservation</title>
  <link href="css/wd_composed_style.css" rel="stylesheet">
  <link href="css/select2.min.css" rel="stylesheet">
  <!--<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />-->
  <!-- Responsive design : system css viewport et utilisation des unités vh et vw) -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <script src="Assets/js/wd_datepicker.js"></script>
  <!-- DARK MODE SWITCH -->
  <div class="container-darkmode bg-white dark:bg-black shadow-xl border-2 border-slate-300 dark:border-slate-800">
    <label class="relative inline-flex items-center mb-5 cursor-pointer">
      <input type="checkbox" id="toggleDarkMode" value="" class="sr-only peer">
      <div class="w-10 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-900 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-800"></div>
      <span id="label_darkmode" class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 break-words"></span>
    </label>
  </div>

    <!-- LOADER PAGE FOR LOADING PAGE -->
  <div class="loader"></div>

  <div class="flex flex-col h-screen w-full justify-center items-center text-gray-900 dark:text-white bg-slate-50 dark:bg-slate-900">