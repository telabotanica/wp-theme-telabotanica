document.querySelectorAll('.js-accordion').forEach((el) => {
  el.addEventListener('click', (e) => {
    const item = e.target.closest('[data-accordion-item]')
    if (!item) return
    item.classList.toggle('is-open')
  })
})
