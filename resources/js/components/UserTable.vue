  <template>
    <div class="card mt-4 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
        <h5 class="mb-0">User Management</h5>
        <button class="btn btn-light btn-sm" @click="openAddModal">
          <i class="bi bi-person-plus"></i> Add User
        </button>
      </div>

      <!-- USERS TABLE -->
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
                <button class="btn btn-warning btn-sm me-2" @click="openEditModal(user)">
                  <i class="bi bi-pencil-square"></i>
                </button>

                <button class="btn btn-danger btn-sm" @click="openDeleteModal(user)">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ADD USER MODAL -->
      <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form @submit.prevent="saveNewUser">
              <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Name</label>
                  <input v-model="newUser.name" class="form-control" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input v-model="newUser.email" type="email" class="form-control" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Role</label>
                  <select v-model="newUser.role" class="form-select">
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                  </select>
                </div>

                <p class="text-muted small">Password is auto-generated from surname.</p>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save User</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- EDIT USER MODAL -->
      <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form @submit.prevent="saveEditUser">
              <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Name</label>
                  <input v-model="editUser.name" class="form-control" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input v-model="editUser.email" type="email" class="form-control" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Role</label>
                  <select v-model="editUser.role" class="form-select">
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                  </select>
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Update User</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- DELETE CONFIRMATION MODAL -->
      <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title">Delete User</h5>
              <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              Are you sure you want to delete <strong>{{ deleteUserData.name }}</strong>?
            </div>

            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button class="btn btn-danger" @click="confirmDelete">Delete</button>
            </div>
          </div>
        </div>
      </div>

      <!-- GLOBAL TOAST -->
      <div
        id="globalToast"
        class="toast align-items-center text-white border-0 position-fixed bottom-0 end-0 m-4"
        role="alert"
        data-bs-delay="2000"
      >
        <div class="d-flex">
          <div id="toastMessage" class="toast-body"></div>
          <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    </div>
  </template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { Modal, Toast } from "bootstrap";

const emit = defineEmits(["updateCount"]);

const users = ref([]);

const newUser = ref({ name: "", email: "", role: "student" });
const editUser = ref({ id: null, name: "", email: "", role: "" });
const deleteUserData = ref({ id: null, name: "" });

/* FETCH USERS */
const fetchUsers = async () => {
  const res = await axios.get("/api/users");
  users.value = res.data;

  // ✅ Emit count AFTER loading
  emit("updateCount", users.value.length);
};

/* TOAST */
const showToast = (msg, type = "success") => {
  const el = document.getElementById("globalToast");
  const msgEl = document.getElementById("toastMessage");

  msgEl.textContent = msg;
  el.classList.remove("bg-success", "bg-danger");
  el.classList.add(type === "success" ? "bg-success" : "bg-danger");

  new Toast(el).show();
};

/* MODALS */
const openAddModal = () => {
  new Modal(document.getElementById("addUserModal")).show();
};

const openEditModal = (user) => {
  editUser.value = { ...user };
  new Modal(document.getElementById("editUserModal")).show();
};

const openDeleteModal = (user) => {
  deleteUserData.value = { ...user };
  new Modal(document.getElementById("deleteUserModal")).show();
};

/* ADD USER */
const saveNewUser = async () => {
  try {
    await axios.post("/api/users", newUser.value);

    showToast("User added successfully!");
    Modal.getInstance(document.getElementById("addUserModal")).hide();

    newUser.value = { name: "", email: "", role: "student" };
    
    await fetchUsers(); // reload first
    emit("updateCount", users.value.length); // 🔥 send count
  } catch {
    showToast("Failed to add user", "danger");
  }
};

/* EDIT USER */
const saveEditUser = async () => {
  try {
    await axios.put(`/api/users/${editUser.value.id}`, editUser.value);

    showToast("User updated successfully!");
    Modal.getInstance(document.getElementById("editUserModal")).hide();

    await fetchUsers();
    emit("updateCount", users.value.length); // 🔥 send count
  } catch {
    showToast("Failed to update user", "danger");
  }
};

/* DELETE USER */
const confirmDelete = async () => {
  try {
    await axios.delete(`/api/users/${deleteUserData.value.id}`);

    showToast("User deleted successfully!");
    Modal.getInstance(document.getElementById("deleteUserModal")).hide();

    await fetchUsers();
    emit("updateCount", users.value.length); // 🔥 send count
  } catch {
    showToast("Failed to delete user", "danger");
  }
};

onMounted(fetchUsers);
</script>


  <style scoped>
  .card {
    border-radius: 10px;
  }
  .modal-content {
    border-radius: 10px;
  }
  </style>
