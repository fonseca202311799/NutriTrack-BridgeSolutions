<template>
  <div class="card shadow-sm mt-4">
    <div
      class="card-header bg-primary text-white d-flex align-items-center justify-content-between"
    >
      <h5 class="mb-0">Settings</h5>
      <i class="bi bi-gear-fill"></i>
    </div>

    <div class="card-body">
      <p class="text-muted mb-4">
        Manage your account and system preferences. More features will be added soon.
      </p>

      <!-- Account Settings -->
      <div class="mb-4">
        <h6 class="fw-bold text-primary"><i class="bi bi-person-circle me-2"></i>Admin Account</h6>
        <form @submit.prevent="saveAccountSettings">
          <div class="mb-3">
            <label class="form-label">Display Name</label>
            <input v-model="account.name" type="text" class="form-control" />
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input v-model="account.email" type="email" class="form-control" />
          </div>
<<<<<<< HEAD
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input v-model="account.password" type="password" class="form-control" />
          </div>
=======
          <!-- <div class="mb-3">
            <label class="form-label">New Password</label>
            <input v-model="account.password" type="password" class="form-control" />
          </div> -->
>>>>>>> act2
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>

      <hr />

      <!-- System Preferences -->
      <div class="mb-3">
        <h6 class="fw-bold text-primary"><i class="bi bi-sliders me-2"></i>System Preferences</h6>

<<<<<<< HEAD
        <div class="form-check form-switch mb-2">
          <input v-model="darkMode" class="form-check-input" type="checkbox" id="darkModeSwitch" />
          <label class="form-check-label" for="darkModeSwitch"> Enable Dark Mode </label>
        </div>
=======
        <!-- <div class="form-check form-switch mb-2">
          <input v-model="darkMode" class="form-check-input" type="checkbox" id="darkModeSwitch" />
          <label class="form-check-label" for="darkModeSwitch"> Enable Dark Mode </label>
        </div> -->
>>>>>>> act2

        <!-- <div class="form-check form-switch">
            <input v-model="notifications" class="form-check-input" type="checkbox" id="notificationSwitch" />
            <label class="form-check-label" for="notificationSwitch">
              Enable Email Notifications
            </label>
          </div> -->
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const account = ref({
  name: 'Admin User',
  email: 'admin@example.com',
  password: '',
})

const darkMode = ref(false)
const notifications = ref(true)

const saveAccountSettings = () => {
  alert('Settings saved successfully!')
}

</script>

<style scoped>
.card {
  border-radius: 10px;
}

.card-header {
  font-weight: 600;
}

.form-label {
  font-weight: 500;
}
</style>
