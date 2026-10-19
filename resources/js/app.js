// Sidebar mobile
const sidebar = document.getElementById('sidebar');
const backdrop = document.getElementById('sidebar-backdrop');
const toggle = document.getElementById('sidebar-toggle');

function setSidebar(open) {
    if (!sidebar || !backdrop) return;
    sidebar.classList.toggle('-translate-x-full', !open);
    backdrop.classList.toggle('hidden', !open);
    toggle?.setAttribute('aria-expanded', String(open));
}

toggle?.addEventListener('click', () => setSidebar(sidebar.classList.contains('-translate-x-full')));
backdrop?.addEventListener('click', () => setSidebar(false));
document.addEventListener('keydown', (e) => e.key === 'Escape' && setSidebar(false));
