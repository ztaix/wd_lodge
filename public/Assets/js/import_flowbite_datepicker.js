import Datepicker from 'flowbite-datepicker/Datepicker';

const datepickerEl = document.getElementById('datepickerId');
const datepickerInstance = new Datepicker(datepickerEl, {
    // options
});

// Plus tard dans votre code, quand vous avez besoin de mettre à jour la date
function updateDate(data) {

    datepickerInstance.setDate(new Date(data.start));
}



