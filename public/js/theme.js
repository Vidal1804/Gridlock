document.addEventListener('DOMContentLoaded', () => {
    const themeBtn = document.getElementById('themeToggleBtn');
    const themeIcon = document.getElementById('themeIcon');
    const body = document.body;

    if (!themeBtn || !themeIcon) return;

    const applyTheme = (theme) => {
        if (theme === 'light') {
            body.classList.add('light-mode');
            themeIcon.src = '/public/resources/sun.png';
            localStorage.setItem('theme', 'light');
        } else {
            body.classList.remove('light-mode');
            themeIcon.src = '/public/resources/moon.png';
            localStorage.setItem('theme', 'dark');
        }
    };

    const savedTheme = localStorage.getItem('theme') || 'dark';
    applyTheme(savedTheme);

    themeBtn.addEventListener('click', () => {
        const isLight = body.classList.contains('light-mode');
        const newTheme = isLight ? 'dark' : 'light';
        
        applyTheme(newTheme);
        
        if (typeof updateMapTheme === 'function') {
            updateMapTheme(newTheme);
        }
    });
});