<?php


$html_form = '';

foreach ($All_config as $row) {
    switch ($row['data_type']) {
        case "input":
            if (strtolower($row['Title']) == strtolower('logo')) {
                $html_form .= '
                <div class="relative mb-5">
                <label for="logo-dropzone-file" class="flex flex-col items-center justify-center w-full h-20 border-2 border-gray-500  border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="w-full flex flex-row items-center justify-between ">
                        ' . (($row['Data']) ? '<div class="rounded-lg bg-slate-200 h-16 ml-2"><img src="' . $row['Data'] . '" class="p-2 object-cover h-full" alt="Logo" /></div>' : '<svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>') . '
                        <div class="flex flex-col items-center justify-center p-5">
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Mettre en ligne ton LOGO </span></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF</p>
                        <p break-word class="w-auto text-xs text-center text-gray-500 dark:text-gray-400" style="word-break: break-word;">' . $row['Data'] . '</p>
                        </div>
                    </div>
                    <input name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '-dropzone-file" type="file" class="hidden" />
                </div>
                ';
            } else {
                $html_form .= '<div class="relative mb-5"><input name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '" type="text" value="' . $row['Data'] . '" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1  appearance-none dark:text-white bg-white border-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 focus:border-2 peer" placeholder=" " />
            <label for="floating_outlined" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] bg-transparent dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-3 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">' . $row['Title'] . '</label></div>';
            }
            break;
        case "textarea":

            if (FreetextToVartext($row['Title']) == 'regles_de_reduction') {
                $discountArray = DiscountToArray($row['Data']);
                $html_discount = '';
                foreach ($discountArray as $nbj => $pourc) {
                    $html_discount .= '<p class="inline-flex">
        <span class="bg-blue-200 text-blue-800 text-xs font-medium px-1.5 rounded dark:bg-blue-900 dark:text-blue-300"> ' . $nbj . ' jours</span>  
        <svg class="w-5 h-5 mx-1 text-slate-300 dark:text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.153 15 19 8l-4.847-7H1l4.848 7L1 15h13.153Z"/>
        </svg>  
        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-1.5 rounded dark:bg-yellow-900 dark:text-yellow-300">-' . $pourc . '% réduction</span></p>
        ';
                }
                $html_form .= '
    <div class="flex flex-col">
    <h1 class="pt-3 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
    ' . $row['Title'] . '
    </h1>
    <div class="grow ">
        <div class="flex">
            <div class="w-1/2 py-2 mr-1">
                <div class="mb-4 w-full rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">

                        <label for="discount" class="sr-only">Règles</label>
                        <h3 class="text-md p-2 font-semibold text-gray-600 dark:text-white border-b dark:border-gray-600">1 règle = 1 ligne:</h3>
                        <textarea name="' . $row['config_id'] . '" id="discount" rows="4" class="w-full border-0 rounded-lg bg-white px-2 text-sm text-gray-900 focus:ring-0 border-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 focus:border-2">' . $row['Data'] . '</textarea>
                    <div class="flex flex-col  border-t px-2 py-2 dark:border-gray-600">
                    <p class="text-xs text-gray-600 dark:text-white underline">Exemple:</p>
                        <p class=" text-xs font-medium text-slate-400"><i>Nombre de nuit : Pourcentage de réduction</i></br>
                        <b>5:15%</b> (exemple: À partir de la 5ᵉ nuit, le client obtient 15% de réduction)</p>
                    </div>
                </div>
            </div>
            <div class="w-1/2 py-2 ml-1">
                <div class="bg-slate-100 rounded-lg shadow border text-center pb-2">
                    <div class="flex items-start justify-between p-2 border-b dark:border-gray-600">
                        <h3 class="text-md font-semibold text-gray-600 dark:text-white">
                        Règles actives
                        </h3>
                    </div>
                        ' . $html_discount . '
                </div>
            </div>
        </div>
    </div>
    ';
            } else {
                $html_form .= '<div class="relative mb-5">

<textarea name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '" rows="4" class="block p-3.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 focus:border-2" >' . $row['Data'] . '</textarea>
<label for="' . FreetextToVartext($row['Title']) . '" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] bg-transparent dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-3 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">' . $row['Title'] . '</label>
</div>
';
            }
            break;
        case "checkbox": //toogle
        default:;
    }
}
?>
<form method="post" action="<?= base_url('/Config/save') ?>" enctype="multipart/form-data">

    <section class="bg-slate-300 dark:bg-gray-900 p-3 sm:p-5" style="padding-bottom: 7rem;">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <h1 class="pt-3 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
            Réglages
        </h1>

            <div class="mb-10">

                <!-- Liste des configuration simples -->
                <?= $html_form; ?>

                <!-- Liste des services -->
                <h1 class="pt-3 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Liste des services
                </h1>
                <h2 class="pt-3 mb-4 text-2xl text-center font-extrabold leading-none tracking-tight text-red-900 md:text-5xl lg:text-6xl dark:text-white"> EN CONSTRUCTION </h2>
                <?php
                foreach ($services_list as $key => $value) {
                ?>
                    <div id="containerService" class="relative w-full pb-2 <?= ($key < $totalServices - 1) ? 'border-b-2' : '' ?> ">
                        <div class="flex items-center pb-4">
                            <div class="w-3/12 flex-shrink-0 overflow-hidden rounded-full" style="border:4px solid <?= $value['Color'] ?>">
                                <img src="<?= isset($value['Image_url']) ? $value['Image_url'] : ''; ?>" id="img_<?= $value['Service_id'] ?>" alt="<?= $value['Title'] ?>" style="object-fit: cover;" />
                            </div>
                            <div class="ml-4 flex flex-grow items-center ">
                                <span class="w-2/3">
                                    <div class="relative z-0">
                                        <input type="text" id="title_<?= $value['Service_id'] ?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="<?= $value['Title'] ?>" placeholder=" " />
                                        <label for="title_<?= $value['Service_id'] ?>" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Titre</label>
                                    </div>
                                </span>
                                <span class="w-1/3 inline-flex">
                                    <div class="relative z-0">
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3/12 flex-shrink-0 rounded-full">
                                <div class="relative text-white">
                                    <input type="text" id="text_color_<?= $value['Service_id'] ?>" class="w-full px-1 p-2 rounded-full text-sm" value="<?= $value['Color'] ?>" style="background-color: <?= $value['Color'] ?>" placeholder="#" />
                                    <input type="color" id="color_<?= $value['Service_id'] ?>" class="absolute top-0 left-0 h-full opacity-0 cursor-pointer" value="<?= $value['Color'] ?>" />
                                </div>
                            </div>
                            <div class="ml-4 flex flex-grow ">
                                <div class="relative z-0 ">
                                    <input type="text" id="comment_<?= $value['Service_id'] ?>" class="block py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="<?= $value['Comment'] ?>" placeholder=" " />
                                    <label for="comment_<?= $value['Service_id'] ?>" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Commentaire</label>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            
        <?php
                }
        ?>
        <button type="button" id="addService" class=" py-1.5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">+ Ajouter un service</button>

        <button type="submit" class="fixed bottom-24 right-6 mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">Enregistrer</button>
        </div>
        </div>
    </section>
</form>

<script>
// Ajout d'un écouteur d'événements 'input' à l'élément d'entrée de couleur
document.getElementById('color_<?= $value["Service_id"] ?>').addEventListener('input', function(event) {
    // Obtention de la nouvelle couleur
    const newColor = event.target.value;

    // Mise à jour de la couleur d'arrière-plan de l'élément d'entrée de texte
    const textInput = document.getElementById('text_color_<?= $value["Service_id"] ?>');
    textInput.style.backgroundColor = newColor;

    // Mise à jour de la valeur de l'élément d'entrée de texte
    textInput.value = newColor;
});

document.querySelector('#addService').addEventListener('click', function() {
    const servicesContainer = document.querySelector('#containerService');
    const serviceCount = servicesContainer.children.length;
    const newServiceId = `new_${serviceCount}`; // Crée un ID unique pour le nouveau service.

    // Créez les champs pour un nouveau service, assurez-vous d'utiliser `newServiceId` pour créer des noms de champs uniques.
    let NewserviceHtml = `
<div class="flex items-center pb-4" id="service_${newServiceId}">
    <div class="w-3/12 flex-shrink-0 overflow-hidden rounded-full" style="border:4px solid #DEFAULTCOLOR">
        <img src="" id="img_${newServiceId}" alt="" style="object-fit: cover;" />
    </div>
    <div class="ml-4 flex flex-grow items-center ">
        <span class="w-2/3">
            <div class="relative z-0">
                <input type="text" id="title_${newServiceId}" name="services[${newServiceId}][title]" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                <label for="title_${newServiceId}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Titre</label>
            </div>
        </span>
        <span class="w-1/3 inline-flex">
            <div class="relative z-0">
                <input type="color" id="color_${newServiceId}" name="services[${newServiceId}][color]" class="w-full h-full opacity-0 cursor-pointer" value="#DEFAULTCOLOR" />
                <input type="text" id="text_color_${newServiceId}" name="services[${newServiceId}][text_color]" class="w-full px-1 p-2 rounded-full text-sm" style="background-color: #DEFAULTCOLOR" placeholder="#" />
            </div>
        </span>
    </div>
</div>
<div class="flex items-center">
    <div class="w-3/12 flex-shrink-0 rounded-full">
        <!-- Placeholder for any other content you might want here -->
    </div>
    <div class="ml-4 flex flex-grow ">
        <div class="relative z-0 ">
            <input type="text" id="comment_${newServiceId}" name="services[${newServiceId}][comment]" class="block py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="comment_${newServiceId}" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Commentaire</label>
        </div>
    </div>
</div>
<button type="button" onclick="removeService('${newServiceId}')" class="mt-4">Supprimer</button>
`;

    // Ajoutez le HTML dans le conteneur de services.
    servicesContainer.innerHTML += NewserviceHtml;
});

function removeService(serviceId) {
    // Supprime le champ de service correspondant.
    const serviceElement = document.querySelector(`#service_${serviceId}`);
    serviceElement.remove();
}</script>