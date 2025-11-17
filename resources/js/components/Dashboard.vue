<template>
  <div>
    <h2 class="mb-4">Dashboard Overview</h2>

<<<<<<< HEAD
    <!-- Example Stats Cards -->
=======
    <!-- Stats Cards -->
>>>>>>> act2
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card text-center p-3">
          <h5>Total Users</h5>
<<<<<<< HEAD
          <p class="display-6 fw-bold text-primary">3</p>
        </div>
      </div>
=======
          <p class="display-6 fw-bold text-primary">{{ totalUsers }}</p>
        </div>
      </div>

>>>>>>> act2
      <div class="col-md-4">
        <div class="card text-center p-3">
          <h5>Active Plans</h5>
          <p class="display-6 fw-bold text-success">2</p>
        </div>
      </div>
<<<<<<< HEAD
=======

>>>>>>> act2
      <div class="col-md-4">
        <div class="card text-center p-3">
          <h5>Reports</h5>
          <p class="display-6 fw-bold text-danger">1</p>
        </div>
      </div>
    </div>

    <!-- User Table Component -->
<<<<<<< HEAD
    <UserTable />
=======
    <UserTable @update-count="totalUsers = $event" />
>>>>>>> act2
  </div>
</template>

<script setup>
<<<<<<< HEAD
import UserTable from './UserTable.vue'
=======
import { ref } from 'vue'
import UserTable from './UserTable.vue'

// reactive value for "Total Users"
const totalUsers = ref(0)
>>>>>>> act2
</script>
