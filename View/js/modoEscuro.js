function modoEscuro() {
    document.body.classList.toggle('dark-mode');
    const links = document.querySelectorAll('.link');
    links.forEach(link => link.classList.toggle('dark-mode'));
}
