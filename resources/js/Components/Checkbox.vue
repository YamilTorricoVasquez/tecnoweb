<template>
  <input
    type="checkbox"
    :id="id"
    :name="name"
    :checked="modelValue"
    @change="$emit('update:modelValue', $event.target.checked)"
    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
  />
</template>

<script>
export default {
  name: 'Checkbox',
  props: {
    modelValue: Boolean,
    id: String,
    name: String,
  },
};
</script>
