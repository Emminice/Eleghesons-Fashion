import './bootstrap';

// Auto-dismiss flash messages after 4 seconds
document.addEventListener('DOMContentLoaded', () => {
    const flashes = document.querySelectorAll('.flash');
    if (flashes.length) {
        setTimeout(() => {
            flashes.forEach(el => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            });
        }, 4000);
    }
});
