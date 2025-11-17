<template>
  <div class="card mt-4 shadow-sm">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Active Plans</h5>
      </div>

      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>User</th>
              <th>Plan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="plan in plans" :key="plan.id">
              <td>{{ plan.user }}</td>
              <td>{{ plan.planName }}</td>
              <td>
                <span class="badge bg-success" v-if="plan.status === 'Active'">Active</span>
                <span class="badge bg-secondary" v-else>{{ plan.status }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'

  const plans = ref([
    { id: 1, user: 'Anna', planName: 'Weight Loss Plan', status: 'Active' },
    { id: 2, user: 'John', planName: 'Muscle Gain Plan', status: 'Active' },
  ])
  </script>

  <style scoped>
  .card {
    border-radius: 10px;
  }
  .table th,
  .table td {
    vertical-align: middle;
  }
  </style>
