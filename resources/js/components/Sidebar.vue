<template>
  <div class="sidebar d-flex flex-column p-3">
    <h4 class="text-white text-center mb-4">NutriTrack</h4>

    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <router-link to="/" class="nav-link d-flex align-items-center text-white" active-class="active">
          <i class="bi bi-speedometer2 me-2"></i>
          <span>Dashboard</span>
        </router-link>
      </li>
      <li class="nav-item mb-2">
        <router-link to="/users" class="nav-link d-flex align-items-center text-white" active-class="active">
          <i class="bi bi-people me-2"></i>
          <span>Users</span>
        </router-link>
      </li>
      <li class="nav-item mb-2">
        <router-link to="/goals" class="nav-link d-flex align-items-center text-white" active-class="active">
          <i class="bi bi-clipboard-check me-2"></i>
          <span>Goals</span>
        </router-link>
      </li>
      <li class="nav-item mb-2">
        <router-link to="/reports" class="nav-link d-flex align-items-center text-white" active-class="active">
          <i class="bi bi-file-earmark-text me-2"></i>
          <span>Reports</span>
        </router-link>
      </li>
      <li class="nav-item mb-2">
        <router-link to="/tips" class="nav-link d-flex align-items-center text-white" active-class="active">
          <i class="bi bi-lightbulb me-2"></i>
          <span>Tips</span>
        </router-link>
      </li>
      <li class="nav-item mb-2">
        <router-link to="/settings" class="nav-link d-flex align-items-center text-white" active-class="active">
          <i class="bi bi-gear me-2"></i>
          <span>Settings</span>
        </router-link>
      </li>
    </ul>

    <div class="mt-auto">
      <a
        href="#"
        class="nav-link d-flex align-items-center text-white logout-link"
        data-bs-toggle="modal"
        data-bs-target="#logoutModal"
      >
        <i class="bi bi-box-arrow-right me-2"></i>
        <span>Logout</span>
      </a>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Confirm Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to log out of your account?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cancel
            </button>
            <button type="button" class="btn btn-danger" @click="confirmLogout">
              Logout
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const confirmLogout = () => {
  const modal = bootstrap.Modal.getInstance(document.getElementById("logoutModal"))
  modal.hide()
  window.location.href = "/login"
}
</script>

