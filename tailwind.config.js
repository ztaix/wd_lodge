/** @type {import('tailwindcss').Config} */
module.exports = {
  mode : 'jit',
  content: [
    './app/Views/**/*.php', // cherche les classes dans tous les fichiers PHP du dossier Views
    './public/css/*.css', 
    './public/js/*.js', 
    './public/Assets/js/*.js', 
    './public/Assets/css/*.css', 
  ],
  darkMode: 'class',
  theme: {
    extend: {
      backgroundColor: {
        'black-90': 'rgba(0, 0, 0, 0.9)', 
        'black-80': 'rgba(0, 0, 0, 0.8)', 
        'black-70': 'rgba(0, 0, 0, 0.7)', 
        'black-60': 'rgba(0, 0, 0, 0.6)', 
        'black-50': 'rgba(0, 0, 0, 0.5)', 
        'black-40': 'rgba(0, 0, 0, 0.4)', 
        'black-30': 'rgba(0, 0, 0, 0.3)', 
        'black-20': 'rgba(0, 0, 0, 0.2)', 
        'black-10': 'rgba(0, 0, 0, 0.1)', 
        'white-90': 'rgba(255, 255, 255, 0.9)', 
        'white-80': 'rgba(255, 255, 255, 0.8)', 
        'white-70': 'rgba(255, 255, 255, 0.7)', 
        'white-60': 'rgba(255, 255, 255, 0.6)', 
        'white-50': 'rgba(255, 255, 255, 0.5)', 
        'white-40': 'rgba(255, 255, 255, 0.4)', 
        'white-30': 'rgba(255, 255, 255, 0.3)', 
        'white-20': 'rgba(255, 255, 255, 0.2)', 
        'white-10': 'rgba(255, 255, 255, 0.1)', 

      },      // Ajouter group-hover pour toutes les classes nécessaires, ici pour small-down-IN
      smallDownIN: ['group-hover'],
      smallDownOUT: ['group-hover'],
      fontSize: {
        'xxs': '.65rem',
      },
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
  }
},

}

