function initSidebarToggle() {
  const sidebar = document.getElementById('sidebar');
  if (!sidebar) return;

  const overlay = document.createElement('div');
  overlay.className = 'sidebar-overlay';
  document.body.appendChild(overlay);

  const isDesktop = () => window.innerWidth >= 992;

  const closeMobile = () => {
    sidebar.classList.remove('sidebar-open');
    overlay.classList.remove('show');
  };

  document.querySelectorAll('[data-sidebar-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      if (isDesktop()) {
        sidebar.classList.toggle('sidebar-collapsed');
      } else {
        if (sidebar.classList.contains('sidebar-open')) {
          closeMobile();
        } else {
          sidebar.classList.add('sidebar-open');
          overlay.classList.add('show');
        }
      }
    });
  });

  document.getElementById('sidebarClose')?.addEventListener('click', closeMobile);
  overlay.addEventListener('click', closeMobile);
}

function initUserDropdown() {
  const toggle = document.getElementById('userMenuToggle');
  if (!toggle) return;

  new bootstrap.Dropdown(toggle, {
    popperConfig(defaultConfig) {
      return { ...defaultConfig, strategy: 'fixed' };
    }
  });

  const chevron = toggle.querySelector('.user-menu-chevron');
  if (chevron) {
    toggle.addEventListener('show.bs.dropdown', () => chevron.classList.add('rotated'));
    toggle.addEventListener('hide.bs.dropdown', () => chevron.classList.remove('rotated'));
  }
}

function initTooltips() {
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
    new bootstrap.Tooltip(el);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initSidebarToggle();
  initUserDropdown();
  initTooltips();
});
