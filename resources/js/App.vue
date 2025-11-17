<template>
  <div id="app" class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" :class="['sidebar', { collapsed: isCollapsed }]">
      <div class="sidebar-header text-center mb-4">
        <h4>NutriTrack</h4>
      </div>
      <ul class="nav flex-column">
        <li class="nav-item">
          <router-link to="/" class="nav-link" active-class="active">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/users" class="nav-link" active-class="active">
            <i class="bi bi-people me-2"></i> Users
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/active-plans" class="nav-link" active-class="active">
            <i class="bi bi-clipboard-check me-2"></i> Active Plans
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/reports" class="nav-link" active-class="active">
            <i class="bi bi-bar-chart me-2"></i> Reports
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/tips" class="nav-link" active-class="active">
            <i class="bi bi-lightbulb me-2"></i> Tips
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/settings" class="nav-link" active-class="active">
            <i class="bi bi-gear me-2"></i> Settings
          </router-link>
        </li>
      </ul>

      <div class="mt-auto pt-4 border-top">
        <a href="#" class="nav-link logout-link" @click.prevent="logout">
          <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1" :class="{ collapsed: isCollapsed }">
      <!-- Top Navbar -->
      <nav class="navbar navbar-light bg-light shadow-sm sticky-top">
        <div>
          <button class="btn btn-outline-primary" @click="toggleSidebar">
            <i class="bi bi-list"></i>
          </button>
        </div>
      </nav>

      <!-- Routed Pages -->
      <main>
        <router-view />
      </main>

      <!-- Footer -->
      <footer class="bg-light text-center py-3 border-top">
        <small>&copy; 2025 BridgeSolutions. All rights reserved.</small>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const isCollapsed = ref(false)

const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
}

const logout = async () => {
  try {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    await fetch('/logout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        'X-Requested-With': 'XMLHttpRequest',
      },
      credentials: 'same-origin',
      body: JSON.stringify({}),
    })
  } catch (e) {
    // ignore; we'll still redirect
  } finally {
    window.location.assign('/login')
  }
}
</script>

<style scoped>
/* Sidebar */
.sidebar {
<<<<<<< HEAD
  width: 250px;
  background: #4caf50;
=======
  width: 240px;
  background: linear-gradient(180deg, #007bff, #004aad);
>>>>>>> act2
  color: white;
  height: 100vh;
  display: flex;
  flex-direction: column;
  position: fixed;
  transition: transform 0.3s ease;
  z-index: 1000;
  padding: 20px;
}

.sidebar.collapsed {
  transform: translateX(-250px);
}

/* Sidebar header */
.sidebar-header h4 {
  font-weight: bold;
  color: #fff;
  margin-bottom: 20px;
}

/* Navigation links */
.nav-link {
  color: rgba(255, 255, 255, 0.9);
  font-weight: 500;
  margin-bottom: 10px;
  border-radius: 8px;
  padding: 10px 15px;
  transition:
    background 0.3s,
    color 0.3s;
}

.nav-link:hover,
.nav-link.active {
  background-color: rgba(255, 255, 255, 0.2);
  color: #fff;
  text-decoration: none;
}

/* Logout link */
.logout-link {
  color: #ffdede;
}

.logout-link:hover {
  background-color: rgba(255, 255, 255, 0.2);
  color: #fff;
}

/* Main content */
.main-content {
<<<<<<< HEAD
  margin-left: 250px;
=======
  margin-right: 35px;
  margin-left: 275px;
>>>>>>> act2
  transition: margin-left 0.3s ease;
  width: calc(100% - 250px);
}

.main-content.collapsed {
<<<<<<< HEAD
  margin-left: 0;
=======
  margin-left: 35px;
>>>>>>> act2
  width: 100%;
}
</style>
