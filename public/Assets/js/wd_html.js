function generateSearchRows(booking) {
  console.log(booking);
  let startDate = format_date(booking.start.slice(0,10));
  let endDate = format_date(booking.end.slice(0,10));

  let Total_price = totalBookingPriceCal(booking.Price,booking.QtTraveller,booking.Tax,booking.Fee,booking.Qt);
  let status_paidObj = generateStatusPaid(booking.Paid,Total_price);
console.log('booking.Paid',booking.Paid);
console.log('Total_price',Total_price);
  let html =`
  <div class=""
  onclick="showBookingDetailsFromID('${ booking.id}');">

    <div class="relative flex m-1" >
    
      <div class="flex flex-grow justify-start">
        <div class="p-1 bg-grey-500 dark:bg-gray-900 rounded-lg">${booking.Type_doc.charAt(0)} #${booking.id}</div>
        
        <div class="ml-1 p-1 inline-flex bg-slate-600 dark:bg-slate-900 rounded-lg">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
          </svg>
          <span class="mx-1">QT </span>
        </div>
        <div class="mx-1 text-lg font-bold">${booking.customer_name}</div>
      </div>

      <div class="flex flex-grow-0 justify-end">
        <div class="w-32 bg-slate-100 shadow-inner shadow-slate-300 rounded-full overflow-hidden">
          <div class="scroll-text justify-start items-center inline-flex">
            <div class=""> ${startDate}</div>
            <div class="">
              <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
              </svg>
            </div>
            <div class=""> ${endDate}</div>
          </div>
        </div>
      </div>

    </div>
    <div class="relative flex" >
    
      <div class="w-full inline-flex justify-start">
        <div class="p-1 bg-grey-500 dark:bg-gray-900 rounded-lg">Nom du service</div>
      </div>

      <div class="flex justify-end">
        <div class="bg-slate-500 rounded-lg">${generateStatusPaid(parseInt(booking.Paid),Total_price)} </div>
      </div>

    </div>

  </div>
  
  `;
    /*let html = `
          <div class="group flex space-x-4 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-600 cursor-pointer" onclick="showBookingDetailsFromID('${
            booking.id
          }');">
            <!-- Colonne 1 -->
            <div class="flex flex-col flex-grow">
              <div class="inline-flex ">
                <div class="rounded-md text-white font-bold text-sm px-1 inline" style="background-color: ${
                  booking.service_color
                }; ">${booking.Type_doc.charAt(0)} #${booking.id}</div>
                
                <div id='booking_${ booking.id }' class="ml-1 transition-all duration-300 group-hover:m-0 group-hover:translate-x-3 font-bold">
                  ${ booking.customer_name + " - " + booking.service_title }
                </div>
              </div>
              <div class="inline-flex flex-grow">
                <div class="flex items-center">
                  ${getDayOfWeek( format_date(booking.start) )} ${format_date(booking.start)} 
                  <svg class="w-3 h-3 text-slate-500 dark:text-white" style="margin: auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                  </svg>
                  ${getDayOfWeek(format_date(booking.end))} ${format_date(booking.end)}
                </div>
              </div>
            </div>
              <!-- Colonne 2 -->
            <div class="flex flex-wrap justify-end font-bold">

              <div class="flex w-full justify-end" >

                <div class="flex flex-col bg-${status_paidObj.color}-100 dark:bg-${status_paidObj.color}-800 rounded-lg px-1">
                  <div class="inline-flex justify-end items-center" >
                      <span class="mr-1 text-xs text-slate-400">Tarif</span> 
                      <span id="booking_total_${booking.id}">${Total_price }</span>
                      <span class="ml-1 text-xs">Fr</span>

                  </div>
                  <div class="inline-flex justify-end items-center" >
                    <span class="mr-1 text-xs text-slate-400">Encaissé</span>   
                    <span class="font-bold" id="booking_paid_${booking.id}">${sumArray(booking.Paid)}</span>
                    <span class="ml-1 text-xs">Fr</span>
                  </div>
                  <div class="inline-flex justify-end items-center" >
                    <span class="font-bold" id="booking_paid_status_${booking.id}">${status_paidObj.html}</span>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <hr class="my-2">
        `;*/
        return html;
  }
  
  function generateStatusPaid(PAIDS,PRICE){
    let html = "";
    let color = "";
    let price = parseInt(PRICE); 
    let paids = parseInt(PAIDS); 

    if(paids >= price){
      html = "<b class='text-green-500 dark:text-green-100'>PAYÉ</b>"; 
      color = "green";
    }
    else if(paids > 0){
      html = "<b class='text-orange-500 dark:text-orange-100'>PARTIEL</b>"
      color = "orange";
    }
    else {
      html = "<b class='text-red-500 dark:text-red-100'>IMPAYÉ</b>";
      color = "red";
    }
    return {html,color};
  }

  function header_modal(title,modal_id){
    return html = `
    <div class="px-2 py-2 lg:px-8 flex justify-between items-center text-slate-500 bg-white border border-gray-200  dark:bg-gray-800 dark:border-gray-700 rounded-b-lg shadow-md " onclick="event.stopPropagation()">
      <div class="flex-grow text-center">
          <h3  class="text-center text-2xl font-bold text-gray-800 dark:text-white">${title}</h3>
      </div> 
      <div>
          <button type="button" class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal" onclick="closeModalById('${modal_id}')">
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class=" sr-only">Fermer</span>
          </button>
      </div>
    </div>`;
  }

  function generateTable(data){
    //create function to generate html
  }