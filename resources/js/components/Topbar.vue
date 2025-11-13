<template>
  <nav
    class="navbar navbar-light bg-white shadow-sm px-4 py-2 d-flex justify-content-between align-items-center"
  >
    <div class="d-flex align-items-center">
      <button class="btn btn-outline-secondary me-3" @click="$emit('toggleSidebar')">☰</button>
    </div>
    <div>
      <span class="me-3 fw-semibold text-secondary">Admin</span>
      <button class="btn btn-outline-danger btn-sm">Logout</button>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Topbar',
}
</script>
