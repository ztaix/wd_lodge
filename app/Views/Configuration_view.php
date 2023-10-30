<?php
/*
echo view('modals/modal_update_add_service', $id); */





$html_form = '';

foreach ($All_config as $row) {
    switch ($row['data_type']) {
        case "input":
            if (strtolower($row['Title']) == strtolower('logo')) {
                $html_form .= '
                <div class="relative mb-5">
                <label for="logo-dropzone-file" class="flex flex-col items-center justify-center w-full h-20 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="w-full flex flex-row items-center justify-between ">
                        ' . (($row['Data']) ? '<div class="rounded-lg bg-slate-200 h-16 ml-2"><img src="' . $row['Data'] . '" class="p-2 object-cover h-full" alt="Logo" /></div>' : '<svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>') . '
                        <div class="flex flex-col items-center justify-center p-5">
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Mettre en ligne ton LOGO </span></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF</p>
                        <p class="text-xs text-center text-gray-500 dark:text-gray-400">' . $row['Data'] . '</p>
                        </div>
                    </div>
                    <input name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '-dropzone-file" type="file" class="hidden" />
                </div>
                ';
            } else {
                $html_form .= '<div class="relative mb-5"><input name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '" type="text" value="' . $row['Data'] . '" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="floating_outlined" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">' . $row['Title'] . '</label></div>';
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
                    <div class="rounded-t-lg bg-white px-4 py-2 dark:bg-gray-800">
                        <label for="discount" class="sr-only">Règles</label>
                        <textarea name="' . $row['config_id'] . '" id="discount" rows="4" class="w-full border-0 bg-white px-0 text-sm text-gray-900 focus:ring-0 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400" required>' . $row['Data'] . '</textarea>
                    </div>
                    <div class="flex flex-col  border-t px-3 py-2 dark:border-gray-600">
                        <p class="px-4  text-xs font-bold text-slate-400">1 règle = 1 ligne:</p>
                        <p class="px-4 py-2.5  text-xs font-medium text-slate-400"><i>Nombre de nuit : Pourcentage de réduction</i></br>
                        <b>5:15%</b> (exemple: À partir de la 5ᵉ nuit, le client obtient 15% de réduction)</p>
                    </div>
                </div>
            </div>
            <div class="w-1/2 py-2 ml-1">
            <div class=" p-3 bg-slate-100 rounded-lg shadow border text-center">
                <div class="flex items-start justify-between p-2 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl -mt-2 font-semibold text-gray-600 dark:text-white">
                    Règles
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

<textarea name="' . $row['config_id'] . '" id="' . FreetextToVartext($row['Title']) . '" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >' . $row['Data'] . '</textarea>
<label for="' . FreetextToVartext($row['Title']) . '" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-gray-50 dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">' . $row['Title'] . '</label>
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

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5" style="padding-bottom: 7rem;">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">

            <!--  Header -->
            <div class="px-6 py-6 lg:px-8 flex">
                <div class="flex-grow">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z" />
                    </svg>
                </div>
                <div class="flex-grow-0">
                    <h3 class="text-center text-2xl font-bold text-gray-800 dark:text-white">Configuration</h3>
                </div>
                <div class="flex-grow">
                </div>
            </div>

            <div class="mb-10">

                <!-- Liste des configuration simples -->
                <?= $html_form; ?>

                <!-- Liste des services -->
                <h1 class="pt-3 mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Liste des services
                </h1>

                <?php
                foreach ($services_list as $key => $value) {
                ?>
                    <div class="relative w-full pb-2 <?= ($key < $totalServices - 1) ? 'border-b-2' : '' ?> ">
                        <div class="flex items-center pb-4">
                            <div class="w-3/12 flex-shrink-0 overflow-hidden rounded-full" style="border:4px solid <?= $value['Color'] ?>">
                                <img src="<?= isset($value['Image_url']) ? $value['Image_url'] : 'img/lodge.jpeg'; ?>" id="img_<?= $value['Service_id'] ?>" alt="<?= $value['Title'] ?>" style="object-fit: cover;" />
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
            </script>
        <?php
                }
        ?>
        <button type="button" class=" py-1.5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">+ Ajouter un service</button>

        <button type="submit" class="fixed bottom-24 right-6 mt-10 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">Enregistrer</button>
        </div>
        </div>
    </section>
</form>