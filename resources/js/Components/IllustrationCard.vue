<template>
  <div class="illustration-card" :class="customClass">
    <div class="illustration-content">
      <img v-if="illustrationSrc" :src="illustrationSrc" :alt="title" class="illustration-image">
      <div v-else class="illustration-placeholder">
        <Icon name="image" size="48" class="text-gray-300" />
      </div>
      <div class="illustration-text">
        <h3 class="illustration-title">{{ title }}</h3>
        <p class="illustration-description">{{ description }}</p>
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import Icon from '@/Components/Icon.vue';

defineProps({
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    default: ''
  },
  illustrationSrc: {
    type: String,
    default: ''
  },
  customClass: {
    type: String,
    default: ''
  }
});
</script>

<style scoped>
.illustration-card {
  background-color: white;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  overflow: hidden;
  transition: all 0.3s ease;
}

.illustration-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.illustration-content {
  display: flex;
  flex-direction: column;
}

.illustration-image {
  width: 100%;
  height: auto;
  object-fit: contain;
  aspect-ratio: 16/9;
  padding: 1rem;
  background-color: #F9FAFB;
}

.illustration-placeholder {
  width: 100%;
  aspect-ratio: 16/9;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #F9FAFB;
}

.illustration-text {
  padding: 1.5rem;
}

.illustration-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #111827;
  margin-bottom: 0.5rem;
}

.illustration-description {
  font-size: 0.875rem;
  color: #6B7280;
  margin-bottom: 1rem;
}

/* Responsive adjustments */
@media (min-width: 768px) {
  .illustration-content {
    flex-direction: row;
    align-items: center;
  }
  
  .illustration-image, 
  .illustration-placeholder {
    width: 40%;
    aspect-ratio: 1;
  }
  
  .illustration-text {
    width: 60%;
  }
}
</style>
