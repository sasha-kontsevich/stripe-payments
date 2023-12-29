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
    const price = button.getAttribute('data-bs-price')
    const planId = button.getAttribute('data-bs-planId')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = checkoutModal.querySelector('.modal-title')
    const modalBodyPlanId = checkoutModal.querySelector('.modal-body #subscr_plan')

    modalTitle.textContent = `Subscribe to ${price} plan`
    modalBodyPlanId.value = planId
  })
}