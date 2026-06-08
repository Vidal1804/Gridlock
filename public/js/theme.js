document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggleBtn');
    const body = document.body;

    if (!themeToggle) return;

    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light-mode');
        themeToggle.checked = true;
    }

    themeToggle.addEventListener('change', function() {
        if (this.checked) {
            body.classList.add('light-mode');
            localStorage.setItem('theme', 'light');
            
            // ENGLISH FUNCTION NAME
            if (typeof updateMapTheme === 'function') updateMapTheme('light');
        } else {
            body.classList.remove('light-mode');
            localStorage.setItem('theme', 'dark');
            
            // ENGLISH FUNCTION NAME
            if (typeof updateMapTheme === 'function') updateMapTheme('dark');
        }
    });
});