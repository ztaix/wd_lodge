function ExistFile(url){
    let exists = false;
    fetch(url)
    .then(response => {
        if (response.ok) {
            exists = true;
        } else {
            exists = false;
        }
    })
    .catch(error => {
        exists = false;
        console.log('Erreur lors de la requête:', error);
    });
    return exists;
}

// MODAL CUSTOMER UPSERT function module
//
  // Met à jour les champs du formulaire avec les données récupérées
  function updateCustomersFormFields(customer) {
    document.getElementById("customer_id").value = customer.customer_id;
    document.getElementById("customer_name").value = customer.name;
    document.getElementById("customer_phone").value = customer.phone;
    document.getElementById("customer_email").value = customer.email;
    document.getElementById("customer_comment").value = customer.comment;
    document.getElementById("Update_customer_Modal_title").innerText = `Modifier Client #${customer.customer_id}`;
  }
  
  function getCustomerFormData() {
    return {
      Customer_id: document.getElementById("customer_id").value,
      Name: document.getElementById("customer_name").value,
      Phone: document.getElementById("customer_phone").value,
      Email: document.getElementById("customer_email").value,
      Comment: document.getElementById("customer_comment").value,
    };
  }