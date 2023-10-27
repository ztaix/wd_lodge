/** @type {import('tailwindcss').Config} */
module.exports = {
  purge: false,
  mode : 'jit',
  content: [
    './app/Views/**/*.php', // cherche les classes dans tous les fichiers PHP du dossier Views
    './public/css/*.css', // cherche également dans tous les fichiers HTML du dossier actuel
    './public/js/*.js', // cherche également dans tous les fichiers HTML du dossier actuel
    './public/Assets/js/*.js', // cherche également dans tous les fichiers HTML du dossier actuel
    './public/Assets/css/*.css', // cherche également dans tous les fichiers HTML du dossier actuel
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        'primary': {
          '50': '#F2F7FA',  // Couleur la plus claire
          '100': '#E4F0F5',
          '200': '#BBDCE5',
          '300': '#93C8D5',
          '400': '#5BA0B0',
          '500': '#1D72B8',  // Couleur principale
          '600': '#1A66A6',
          '700': '#12526D',
          '800': '#0E3E51',
          '900': '#0A2A36',  // Couleur la plus foncée
        }     
      }
    },
    fontFamily: {
      'body': [
    'Inter', 
    'ui-sans-serif', 
    'system-ui', 
    '-apple-system', 
    'system-ui', 
    'Segoe UI', 
    'Roboto', 
    'Helvetica Neue', 
    'Arial', 
    'Noto Sans', 
    'sans-serif', 
    'Apple Color Emoji', 
    'Segoe UI Emoji', 
    'Segoe UI Symbol', 
    'Noto Color Emoji'
  ],
      'sans': [
    'Inter', 
    'ui-sans-serif', 
    'system-ui', 
    '-apple-system', 
    'system-ui', 
    'Segoe UI', 
    'Roboto', 
    'Helvetica Neue', 
    'Arial', 
    'Noto Sans', 
    'sans-serif', 
    'Apple Color Emoji', 
    'Segoe UI Emoji', 
    'Segoe UI Symbol', 
    'Noto Color Emoji'
  ]
  }
},
  plugins: [
    require('flowbite/plugin')
]

}

