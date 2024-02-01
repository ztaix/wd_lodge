function generateBookingElement(booking) {
    let Total_price = totalBookingPriceCal(booking.Price,booking.QtTraveller,booking.Tax,booking.Fee,booking.nDays);
    return `
          <div class="flex space-x-4" >
            <!-- Colonne 1 -->
            <div class="flex-grow">
              <div class="rounded-md text-white font-bold text-sm px-1 inline" style="background-color: ${
                booking.service_color
              }; ">#${booking.id}</div>
              
              <a href="#" id='booking_${
                booking.id
              }' onclick="showBookingDetailsFromID('${
      booking.id
    }');" class="text-blue-500 hover:underline ">${
      booking.customer_name + " - " + booking.service_title
    }</a>
              <div class="flex">${getDayOfWeek(
                format_date(booking.start)
              )} ${format_date(booking.start)} 
                  <svg class="w-3 h-3 text-slate-500 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                  </svg>${getDayOfWeek(format_date(booking.end))} ${format_date(
      booking.end
    )}</div>
            </div>
            <!-- Colonne 2 -->
            <div class="flex flex-wrap justify-end font-bold">
              <div class="svg-delete text-right">
                  <svg onclick=onclick="deleteEvent(event, '${booking.id}', 'ListEventModal')" class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                  </svg>
              </div>
              <div class="flex w-full  justify-end" >
                  <svg class="w-4 h-4 dark:text-white" style="margin: auto 0.5rem auto 0.5rem;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1M2 5h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                  </svg> ${Total_price} Fr
              </div>
            </div>
          </div>
          <hr class="my-2">
        `;
  }
  