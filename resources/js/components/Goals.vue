<template>
  <div class="card mt-4 shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Goals</h5>
      <div class="small">
        <span class="badge bg-light text-dark me-2">Total: {{ meta.count }}</span>
        <span class="badge bg-success me-2">Active: {{ meta.active }}</span>
        <span class="badge bg-secondary">Completed: {{ meta.completed }}</span>
      </div>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Student</th>
            <th>Goal</th>
            <th>Target</th>
            <th>Status</th>
            <th>Updated</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="goals.length === 0">
            <td colspan="5" class="text-center text-muted">No goals found.</td>
          </tr>
          <tr v-for="g in goals" :key="g.id">
            <td>{{ g.student_name }}</td>
            <td>{{ g.goal_type }}</td>
            <td>
              <span v-if="g.target_value">
                {{ g.current_value }} / {{ g.target_value }} {{ g.target_unit || '' }}
              </span>
              <span v-else>{{ g.target }}</span>
            </td>
            <td>
              <span class="badge" :class="g.is_completed ? 'bg-secondary' : 'bg-success'">
                {{ g.is_completed ? 'Completed' : 'Active' }}
              </span>
            </td>
            <td>{{ new Date(g.updated_at).toLocaleDateString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const goals = ref([])
const meta = ref({ count: 0, active: 0, completed: 0 })

onMounted(async () => {
  try {
    const { data } = await axios.get('/admin/api/goals')
    goals.value = data.data || []
    meta.value = data.meta || { count: goals.value.length, active: goals.value.filter(g=>!g.is_completed).length, completed: goals.value.filter(g=>g.is_completed).length }
  } catch (e) {
    console.error('Failed to load goals', e)
  }
})
</script>

<style scoped>
.card { border-radius: 10px; }
.table th, .table td { vertical-align: middle; }
</style>
