<template>
  <div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-lightbulb me-2"></i>Send Personalized Tips</h2>

    <!-- Student List -->
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body">
        <h5 class="mb-3">Students</h5>
        <ul class="list-group">
          <li
            v-for="student in students"
            :key="student.id"
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            <span>
              <strong>{{ student.user?.name }}</strong>
              <small class="text-muted ms-2">{{ student.user?.email }}</small>
              <br />
              <small class="text-muted">Grade: {{ student.grade_level || '—' }} • Age: {{ student.age || '—' }} • ID: {{ student.student_id || '—' }}</small>
            </span>
            <button
              class="btn btn-outline-primary btn-sm"
              @click="openTipModal(student)"
            >
              <i class="bi bi-send"></i> Send Tip
            </button>
          </li>
        </ul>
      </div>
    </div>

    <!-- Tip Modal -->
    <div v-if="showModal" class="modal-backdrop" @click.self="closeTipModal">
      <div class="modal-content p-4" style="max-width:400px; margin:auto;">
        <h5 class="mb-3">Send Tip to {{ modalUser.name }}</h5>
        <form @submit.prevent="submitTip">
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
          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" @click="closeTipModal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-send me-1"></i> Send Tip
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Success Alert -->
    <div
      v-if="submitted"
      class="alert alert-success alert-dismissible fade show mt-4"
      role="alert"
    >
      ✅ Tip successfully sent to <strong>{{ modalUser.name }}</strong>!
      <button type="button" class="btn-close" @click="submitted = false"></button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const students = ref([])
const showModal = ref(false)
const modalUser = ref({})
const tipMessage = ref('')
const submitted = ref(false)

const fetchStudents = async () => {
  try {
    const res = await axios.get('/api/students')
    students.value = Array.isArray(res.data) ? res.data : []
  } catch (err) {
    console.error('Failed to fetch students:', err)
  }
}

onMounted(fetchStudents)

const openTipModal = (student) => {
  modalUser.value = {
    id: student.user?.id,
    name: student.user?.name,
    email: student.user?.email,
    student_id: student.student_id,
  }
  tipMessage.value = ''
  showModal.value = true
  submitted.value = false
}

const closeTipModal = () => {
  showModal.value = false
}

const submitTip = async () => {
  if (modalUser.value.id && tipMessage.value) {
    // Replace with API call to backend to store tip
    console.log('Tip submitted:', {
      userId: modalUser.value.id,
      studentId: modalUser.value.student_id,
      message: tipMessage.value,
    })
    showModal.value = false
    submitted.value = true
    tipMessage.value = ''
  }
}
</script>

<style scoped>
.container {
  max-width: 600px;
}
.modal-backdrop {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.25);
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-content {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.18);
}
</style>
