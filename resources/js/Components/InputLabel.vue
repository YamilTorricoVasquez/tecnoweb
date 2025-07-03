<template>
  <label :for="id" class="block text-sm font-medium text-gray-700">
    <slot />
  </label>
</template>

<script>
export default {
  props: {
    for: String
  }
};
</script>
