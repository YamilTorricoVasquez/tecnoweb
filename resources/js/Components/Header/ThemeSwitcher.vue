<script setup lang="ts">
import { useThemeStore } from '@/stores/themeStore'

const themeStore = useThemeStore()

const themes = [
  { value: 'kids', label: 'Niños' },
  { value: 'young', label: 'Jóvenes' },
  { value: 'adult', label: 'Adultos' }
]
</script>

<template>
  <div class="flex items-center gap-2">
    <label for="theme-select" class="font-medium">Tema:</label>
    <select
      id="theme-select"
      class="rounded border px-2 py-1"
      :value="themeStore.theme"
      @change="themeStore.setTheme($event.target.value)"
    >
      <option v-for="theme in themes" :key="theme.value" :value="theme.value">
        {{ theme.label }}
      </option>
    </select>
  </div>
</template>
