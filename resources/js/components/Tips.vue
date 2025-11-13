<template>
  <div class="container py-4">
      <h2 class="mb-4"><i class="bi bi-lightbulb me-2"></i>Personalized Tips</h2>

      <div class="card shadow-sm border-0">
        <div class="card-body">
          <form @submit.prevent="submitTip">
            <!-- Select User -->
            <div class="mb-3">
              <label for="user" class="form-label fw-semibold">Select User</label>
              <select v-model="selectedUser" id="user" class="form-select" required>
                <option value="" disabled>Select a user</option>
                <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.name }}
                </option>
              </select>
            </div>

            <!-- Tip Message -->
            <div class="mb-3">
              <label for="tipMessage" class="form-label fw-semibold">Tip Message</label>
              <textarea
                v-model="tipMessage"
                id="tipMessage"
                rows="4"
                class="form-control"
                placeholder="Write a personalized nutrition tip here..."
                required
              ></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-send me-1"></i> Send Tip
            </button>
          </form>
        </div>
      </div>

      <!-- Success Alert -->
      <div
        v-if="submitted"
        class="alert alert-success alert-dismissible fade show mt-4"
        role="alert"
      >
        ✅ Tip successfully sent to <strong>{{ getUserName(selectedUser) }}</strong>!
        <button type="button" class="btn-close" @click="submitted = false"></button>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'

  const users = ref([
    { id: 1, name: 'John Doe' },
    { id: 2, name: 'Jane Smith' },
    { id: 3, name: 'Michael Brown' },
  ])

  const selectedUser = ref('')
  const tipMessage = ref('')
  const submitted = ref(false)

  const submitTip = () => {
    if (selectedUser.value && tipMessage.value) {
      console.log('Tip submitted:', {
        userId: selectedUser.value,
        message: tipMessage.value,
      })
      submitted.value = true
      tipMessage.value = ''
      selectedUser.value = ''
    }
  }

  const getUserName = (id) => {
    const user = users.value.find((u) => u.id === id)
    return user ? user.name : ''
  }
  </script>

  <style scoped>
  .container {
    max-width: 600px;
  }
  </style>
