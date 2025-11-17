<template>
  <div>
    <h2 class="mb-4">Dashboard Overview</h2>

    <!-- Stats Cards -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card text-center p-3">
          <h5>Total Users</h5>
          <p class="display-6 fw-bold text-primary">{{ totalUsers }}</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center p-3">
          <h5>Active Plans</h5>
          <p class="display-6 fw-bold text-success">2</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center p-3">
          <h5>Reports</h5>
          <p class="display-6 fw-bold text-danger">1</p>
        </div>
      </div>
    </div>

    <!-- User Table Component -->
    <UserTable @update-count="totalUsers = $event" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UserTable from './UserTable.vue'

// reactive value for "Total Users"
const totalUsers = ref(0)
</script>
