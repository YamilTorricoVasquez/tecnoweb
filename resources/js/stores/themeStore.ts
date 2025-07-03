// src/stores/themeStore.ts
import { ref, watch } from 'vue'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

export const useThemeStore = defineStore('theme', () => {
  const theme = useStorage('theme', ref<'kids' | 'young' | 'adult'>('kids'))

  // Al iniciar, aplica el tema almacenado
  document.documentElement.classList.add(`theme-${theme.value}`)

  // Función para cambiar el tema
  function setTheme(newTheme: 'kids' | 'young' | 'adult') {
    document.documentElement.classList.remove(`theme-${theme.value}`)
    theme.value = newTheme
    document.documentElement.classList.add(`theme-${theme.value}`)
  }

  // Si cambia desde cualquier parte de la app, se actualiza
  watch(theme, (newVal, oldVal) => {
    document.documentElement.classList.remove(`theme-${oldVal}`)
    document.documentElement.classList.add(`theme-${newVal}`)
  })

  return {
    theme,
    setTheme,
  }
})
