<template>
  <div class="card mt-4 shadow-sm">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Progress Reports</h5>
      </div>

      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>User</th>
              <th>Summary</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="report in reports" :key="report.id">
              <td>{{ report.user }}</td>
              <td>{{ report.summary }}</td>
              <td>{{ report.date }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'

  const reports = ref([
    { id: 1, user: 'Anna', summary: 'Lost 1.5 kg this week', date: 'Oct 10, 2025' },
    { id: 2, user: 'John', summary: 'Gained 2 kg of muscle', date: 'Oct 12, 2025' },
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
