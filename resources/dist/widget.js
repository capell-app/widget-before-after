const initialise = (root) => {
    if (root.classList.contains('is-ready')) return
    root.classList.add('is-ready')
    root.querySelector('[data-comparison-range]')?.addEventListener(
        'input',
        (event) =>
            root.style.setProperty(
                '--comparison-position',
                `${event.currentTarget.value}%`,
            ),
    )
}
document.querySelectorAll('[data-capell-before-after]').forEach(initialise)
document.addEventListener('capell:content-ready', (event) =>
    event.target
        ?.querySelectorAll?.('[data-capell-before-after]')
        .forEach(initialise),
)
