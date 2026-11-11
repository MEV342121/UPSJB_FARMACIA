<aside id="sidebar" class="bg-dark text-white d-flex flex-column flex-shrink-0" aria-label="Navegación principal">

    <div class="d-flex align-items-center px-3 pt-4 pb-3">
      <div class="brand-icon rounded-circle bg-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0">
        <i class="bi bi-plus-lg text-white fs-5 fw-bold"></i>
      </div>
      <div class="lh-sm overflow-hidden flex-grow-1">
        <div class="text-white fw-bold fs-5 lh-1">SJB</div>
        <div class="sidebar-section-title text-white-50 fw-normal mt-1">Sistema de Venta de Medicamentos</div>
      </div>
      <button id="sidebarClose" class="btn-close btn-close-white d-lg-none" aria-label="Cerrar menú"></button>
    </div>

    <hr class="mx-3 my-0" style="border-color:rgba(255,255,255,.1)">

    <nav class="sidebar-nav flex-grow-1 overflow-y-auto py-3 px-2">

      <p class="sidebar-section-title text-white-50 text-uppercase fw-semibold px-3 mb-2 mt-2">Principal</p>
      <ul class="nav flex-column gap-1 mb-1">
        <li class="nav-item">
          <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2 active_item" aria-current="">
            <i class="bi bi-house-door fs-6"></i><span class="small fw-medium">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2" aria-current="">
            <i class="bi bi-bar-chart fs-6"></i><span class="small fw-medium">Reportes</span>
          </a>
        </li>
      </ul>

      <p class="sidebar-section-title text-white-50 text-uppercase fw-semibold px-3 mb-2 mt-3">Gestión</p>
      <ul class="nav flex-column gap-1 mb-1">
            <li class="nav-item">
            <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2" aria-current="">
            <i class="bi bi-box-seam fs-6"></i><span class="small fw-medium">Medicamentos</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2" aria-current="">
            <i class="bi bi-people fs-6"></i><span class="small fw-medium">Clientes</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2" aria-current="">
            <i class="bi bi-cart3 fs-6"></i><span class="small fw-medium">Ventas</span>
          </a>
        </li>
      </ul>

      <p class="sidebar-section-title text-white-50 text-uppercase fw-semibold px-3 mb-2 mt-3">Configuraciones</p>
      <ul class="nav flex-column gap-1">
        <li class="nav-item">
          <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2" aria-current="">
            <i class="bi bi-shield fs-6"></i><span class="small fw-medium">Roles</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2" aria-current="">
            <i class="bi bi-person-gear fs-6"></i><span class="small fw-medium">Usuarios</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link sidebar-link text-white-50 rounded-4 px-3 py-2 d-flex align-items-center gap-2" aria-current="">
            <i class="bi bi-grid fs-6"></i><span class="small fw-medium">Categorías</span>
          </a>
        </li>
      </ul>

    </nav>

    <div class="dropup" style="border-top:1px solid rgba(255,255,255,.1)">
      <button class="btn w-100 d-flex align-items-center gap-2 text-start px-3 py-3 sidebar-user-btn"
              id="userMenuToggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              aria-haspopup="true"
              aria-label="Opciones de cuenta">
        <div class="user-avatar rounded-circle bg-primary d-flex align-items-center justify-content-center flex-shrink-0">
          <span class="text-white fw-bold lh-1">SJ</span>
        </div>
        <div class="lh-sm overflow-hidden flex-grow-1 text-start">
          <div class="text-white fw-semibold small">Administrador</div>
          <div class="text-white-50" style="font-size:.7rem">admin@sanjuan.com</div>
        </div>
        <i class="bi bi-chevron-up text-white-50 small user-menu-chevron"></i>
      </button>
      <ul class="dropdown-menu shadow border" style="min-width:235px">
        <li class="px-3 py-2 border-bottom" style="background:var(--bs-tertiary-bg)">
          <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width:40px;height:40px">
              <span class="text-white fw-bold small">SJ</span>
            </div>
            <div class="lh-sm overflow-hidden">
              <div class="fw-semibold small">Administrador</div>
              <div class="text-secondary" style="font-size:.7rem">admin@sanjuan.com</div>
              <span class="badge bg-primary-subtle text-primary mt-1 px-2 rounded-pill" style="font-size:.6rem;font-weight:600">Super Admin</span>
            </div>
          </div>
        </li>
        <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 small" href="#" data-bs-toggle="modal" data-bs-target="#profileModal"><i class="bi bi-person-circle fs-6 text-secondary"></i>Mi Perfil</a></li>
        <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 small" href="#"><i class="bi bi-shield-lock fs-6 text-secondary"></i>Cambiar Contraseña</a></li>
        <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 small" href="#"><i class="bi bi-sliders fs-6 text-secondary"></i>Preferencias</a></li>
        <li><hr class="dropdown-divider my-1"></li>
        <li><a class="dropdown-item d-flex align-items-center gap-2 py-2 small text-danger fw-medium" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-box-arrow-right fs-6"></i>Cerrar Sesión</a></li>
      </ul>
    </div>

  </aside>