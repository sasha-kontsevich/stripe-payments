function checkout(priceId, customerId) {
  fetch('/create-subscription', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      priceId: priceId,
      customerId: customerId,
    }),
  })
}

const checkoutModal = document.getElementById('checkoutModal')
if (checkoutModal) {
  checkoutModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute('data-bs-price')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = checkoutModal.querySelector('.modal-title')
    const modalBodyInput = checkoutModal.querySelector('.modal-body input')

    modalTitle.textContent = `New message to ${recipient}`
    modalBodyInput.value = recipient
  })
}