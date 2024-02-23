<?php


$html_form = '';

foreach ($All_config as $row) {
    switch ($row['data_type']) {
            /*case "radio":
            if(FreetextToVartext($row['Title']) == "portee_de_reduction"){
                $both = $global = $unit = '';
                if(strtolower($row['Data']) == strtolower('Both')){
                    $both = 'checked';
                }
                elseif(strtolower($row['Data']) == strtolower('Global')){
                    $global = 'checked';
                }
                elseif(strtolower($row['Data']) == strtolower('Unit')){
                    $unit = 'checked';
                }
                else{
                    $both = $global = $unit = '';
                }
                $html_form .= '
                <h1 class="pt-3 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                ' . $row['Title'] . $global .'
                </h1>
                <div class="py-2">
                    <ul class="inline-flex items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input '.$both.' id="Les deux" type="radio" value="Both" name="' . $row['config_id'] . '" class="w-4 h-4 ml-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="Les deux" class="w-full py-4 ms-2 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Les deux</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input '.$global.' id="Global" type="radio" value="Global" name="' . $row['config_id'] . '" class="w-4 h-4 ml-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="Global" class="w-full py-4 ms-2 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Global</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input '.$unit.' id="Par service" type="radio" value="Unit" name="' . $row['config_id'] . '" class="w-4 h-4 ml-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="Par service" class="w-full py-4 ms-2 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Par service</label>
                            </div>
                        </li>
                    </ul>
                </div>
                ';
            }
            if(FreetextToVartext($row['Title']) == "type_de_reduction"){
                $fixe_checked = $pourcentage_checked = '';
                (strtolower($row['Data']) == strtolower('Fixe')) ? $fixe_checked = 'checked' : $pourcentage_checked = 'checked' ;
             
                $html_form .= '
                <div class="flex gap-4">
                    <div class="flex-1">
                        <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                            <input '.$fixe_checked.' id="Fixe" type="radio" value="Fixe" name="' . $row['config_id'] . '" class="w-4 h-4 ml-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="Fixe" class="w-full py-4 ms-2 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Fixe</label>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                            <input '.$pourcentage_checked.' id="Pourcentage" type="radio" value="Pourcentage" name="' . $row['config_id'] . '" class="w-4 h-4 ml-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="Pourcentage" class="w-full py-4 ms-2 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Pourcentage</label>
                        </div>
                    </div>
                </div>
                ';
            }

            break;*/
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
                    <input name="logo" id="' . FreetextToVartext($row['Title']) . '-dropzone-file" type="file" class="hidden" />
                </div>
                ';
            } else {
                $html_form .= '<div class="relative mb-5"><input name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '" type="text" value="' . $row['Data'] . '" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1  appearance-none dark:text-white bg-white dark:bg-gray-700 border-gray-500 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 focus:border-2 peer" placeholder=" " />
            <label for="floating_outlined" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] bg-transparent px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-3 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">' . $row['Title'] . '</label></div>';
            }
            break;
        case "textarea":
            // !!! PORTé de réduction EN CONSTRUCTION !!!! //
            /*if (FreetextToVartext($row['Title']) == 'regles_de_reduction') {
                $discountArray = DiscountToArray($row['Data']);
                $html_discount = '';
                if(is_array($discountArray)){
                foreach ($discountArray as $nbj => $value) {
                    $discount = strtolower($discountRules['Type']['Data']) == strtolower("Fixe")? $value ." Fr par nuit" : "-".$value ." % de réduction";
                    $html_discount .= '
                    <div class="flex flex-col items-center">
                        <p class="inline-flex">
                            <span class="bg-blue-200 text-blue-800 text-xs font-medium px-1.5 rounded dark:bg-blue-900 dark:text-blue-300"> ' . $nbj . ' jours</span>  
                            <svg class="w-5 h-5 mx-1 text-slate-300 dark:text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.153 15 19 8l-4.847-7H1l4.848 7L1 15h13.153Z"/>
                            </svg>  
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-1.5 rounded dark:bg-yellow-900 dark:text-yellow-300">' . $discount .'</span>
                        </p>
                    </div>
                    ';
                }}
                else{
                    $html_discount .= '<div class="flex flex-col items-center">
                    <p class="inline-flex">                        
                    <span class="bg-yellow-100 mt-2 text-yellow-800 text-xs font-medium px-1.5 rounded dark:bg-yellow-900 dark:text-yellow-300"> Aucune règles global créée</span></p>
                    </p></div>';

                }
                $html_form .= '
<div class="flex flex-col">

    <div class="grow ">
        <div class="flex">
            <div class="w-1/2 py-2 mr-1">
                <div class="mb-4 w-full rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">

                    <label for="discount" class="sr-only">Règles</label>
                    <h3 class="text-md p-2 font-semibold text-gray-600 dark:text-white border-b dark:border-gray-600">1 règle = 1 ligne:</h3>
                    <textarea name="' . $row['config_id'] . '" id="discount" rows="4" class="w-full border-0 rounded-lg bg-white px-2 text-sm text-gray-900 focus:ring-0 border-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 focus:border-2">' . $row['Data'] . '</textarea>
                    <div class="flex flex-col  border-t px-2 py-2 dark:border-gray-600">
                        <p class="text-xs text-gray-600 dark:text-white underline">Exemple:</p>
                        <p class=" text-xs font-medium text-slate-400"><b>SI FIXE :</b><i>Nombre de nuit : Prix par nuit réduit</i></br>
                        <b>5:5000</b> (exemple: À partir de la 5ᵉ nuit, le client paiera 5000 Fr par nuit)</p>
                        <p class=" text-xs font-medium text-slate-400"><b>SI POURCENTAGE :</b><i>Nombre de nuit : Pourcentage de réduction</i></br>
                        <b>5:15%</b> (exemple: À partir de la 5ᵉ nuit, le client obtient 15% de réduction)</p>
                    </div>
                </div>
            </div>
            <div class="w-1/2 py-2 ml-1">
                <div class="text-gray-900 dark:text-white bg-slate-50 dark:bg-slate-500 rounded-lg shadow border dark:border-slate-400 text-center pb-2">
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
</div>
    ';
            } else {*/

            if (FreetextToVartext($row['Title']) !== 'regles_de_reduction') {
                $html_form .= '
                <div class="relative mb-5">
                    <textarea name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '" rows="4" class="block p-3.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 focus:border-2" >' . $row['Data'] . '</textarea>
                    <label for="' . FreetextToVartext($row['Title']) . '" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] bg-transparent  px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-3 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">' . $row['Title'] . '</label>
                </div>
                ';
            }
            break;
        case "checkbox": //toogle
        default:
            '';
    }
}
?>
<div id="history" class="max-w-screen-md bg-gray-50 dark:bg-gray-900">

    <header class="mb-2">Configuration</header>

    <div class="mx-auto px-4">
        <!-- Start Container -->
        <form id="configForm" method="post" enctype="multipart/form-data">

            <div class="mb-10">

                <!-- Liste des configuration simples -->
                <?= $html_form; ?>

            </div>
            <button type="button" id="saveConfig" class="sticky bottom-4 float-right mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 shadow-xl">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('saveConfig').addEventListener('click', function() {
        const formElement = document.getElementById('configForm');
        const formData = new FormData(formElement);
        const objectData = {};
        formData.forEach((value, key) => {
            objectData[key] = value;
        });

        // Utilisation de ajaxCall pour soumettre le formulaire
        ajaxCall(
            'Config/save',
            'POST',
            objectData,
            function(response) { // Callback de succès
                showBanner('Enregistrement réussi', true);
                console.log('Réponse succès:', response);
                // Vous pouvez ici gérer la réponse de succès, par exemple en affichant un message de succès ou en redirigeant l'utilisateur
            },
            function(error) { // Callback d'erreur
                showBanner('Erreur dans l\'enregistrement', false);
                console.error('Réponse erreur:', error);
                // Vous pouvez ici gérer les erreurs, par exemple en affichant un message d'erreur
            }
        );
    });
</script>