<template>
  <div class="row g-3 mb-4">
    <div
      v-for="(item, idx) in items"
      :key="idx"
      class="col-12 col-sm-6 col-lg-4"
    >
      <component :is="item.to ? 'router-link' : 'div'" :to="item.to" class="text-decoration-none">
        <div class="card h-100 shadow-sm feature-card" :style="cardStyle(item)">
          <div class="card-body d-flex align-items-start">
            <div class="me-3 rounded-circle icon-wrap d-flex align-items-center justify-content-center" :style="iconWrapStyle(item)">
              <i :class="item.icon"></i>
            </div>
            <div>
              <h5 class="card-title mb-1" :class="textColor(item)">{{ item.title }}</h5>
              <small class="text-muted">{{ item.subtitle }}</small>
            </div>
          </div>
        </div>
      </component>
    </div>
  </div>

</template>

<script setup>
const props = defineProps({
  items: {
    type: Array,
    required: true,
    default: () => [],
  },
})

const cardStyle = (item) => ({
  backgroundColor: item.bg || '#ffffff',
  border: '1px solid rgba(0,0,0,0.05)',
})

const iconWrapStyle = (item) => ({
  width: '42px',
  height: '42px',
  backgroundColor: item.tint || 'rgba(76, 175, 80, 0.12)',
  color: item.color || '#4caf50',
})

const textColor = (item) => (item.textColor ? '' : 'text-dark')
</script>

<style scoped>
.feature-card {
  border-radius: 12px;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.feature-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
}
.icon-wrap {
  min-width: 42px;
  border-radius: 50%;
}
</style>
