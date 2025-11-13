<template>
  <div class="card mt-4 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
      <h5 class="mb-0">User Management</h5>
      <button
        class="btn btn-light btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#addUserModal"
      >
        <i class="bi bi-person-plus"></i> Add User
      </button>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.role }}</td>
            <td class="text-center">
              <button
                class="btn btn-warning btn-sm me-2"
                data-bs-toggle="modal"
                data-bs-target="#editUserModal"
                @click="setEditUser(user)"
              >
                <i class="bi bi-pencil-square"></i>
              </button>
              <button
                class="btn btn-danger btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#deleteUserModal"
                @click="setDeleteUser(user)"
              >
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form @submit.prevent="saveNewUser">
            <div class="modal-header">
              <h5 class="modal-title">Add New User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input v-model="newUser.name" type="text" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input v-model="newUser.email" type="email" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Role</label>
                <select v-model="newUser.role" class="form-select" required>
                  <option>User</option>
                  <option>Admin</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form @submit.prevent="saveEditUser">
            <div class="modal-header">
              <h5 class="modal-title">Edit User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input v-model="editUser.name" type="text" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input v-model="editUser.email" type="email" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Role</label>
                <select v-model="editUser.role" class="form-select" required>
                  <option>User</option>
                  <option>Admin</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title">Delete Confirmation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete <strong>{{ deleteUserData.name }}</strong>?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" @click="confirmDelete">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Initial mock users (will be replaced with PHP backend later)
const users = ref([
  { id: 1, name: 'Alice', email: 'alice@example.com', role: 'User' },
  { id: 2, name: 'Bob', email: 'bob@example.com', role: 'User' },
  { id: 3, name: 'Charlie', email: 'charlie@example.com', role: 'User' }
])


const newUser = ref({ name: '', email: '', role: 'User' })
const editUser = ref({ id: null, name: '', email: '', role: 'User' })
const deleteUserData = ref({ id: null, name: '' })

// Add
const saveNewUser = () => {
  const nextId = users.value.length ? Math.max(...users.value.map(u => u.id)) + 1 : 1
  users.value.push({ id: nextId, ...newUser.value })
  newUser.value = { name: '', email: '', role: 'User' }
  bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide()
}

// Edit
const setEditUser = (user) => {
  editUser.value = { ...user }
}

const saveEditUser = () => {
  const index = users.value.findIndex(u => u.id === editUser.value.id)
  if (index !== -1) users.value[index] = { ...editUser.value }
  bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide()
}

// Delete
const setDeleteUser = (user) => {
  deleteUserData.value = { ...user }
}

const confirmDelete = () => {
  users.value = users.value.filter(u => u.id !== deleteUserData.value.id)
  bootstrap.Modal.getInstance(document.getElementById('deleteUserModal')).hide()
}
</script>

<style scoped>
.card {
  border-radius: 10px;
}

.table th, .table td {
  vertical-align: middle;
}

.modal-content {
  border-radius: 8px;
}
</style>
