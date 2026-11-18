const initialise = (root) => {
    if (root.classList.contains('is-ready')) return
    root.classList.add('is-ready')
    root.querySelector('[data-comparison-range]')?.addEventListener(
        'input',
        (event) => {
            const range = event.currentTarget
            root.style.setProperty('--comparison-position', `${range.value}%`)
            // Screen readers announce this text rather than a bare number.
            const template = root.dataset.positionText
            if (template)
                range.setAttribute(
                    'aria-valuetext',
                    template.replaceAll(':percent', range.value),
                )
        },
    )
}
document
    .querySelectorAll('[data-capell-widget-before-after]')
    .forEach(initialise)
document.addEventListener('capell:content-ready', (event) =>
    event.target
        ?.querySelectorAll?.('[data-capell-widget-before-after]')
        .forEach(initialise),
)
