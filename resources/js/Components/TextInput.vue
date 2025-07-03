<template>
  <input
    :id="id"
    :type="type"
    :name="name"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    :autocomplete="autocomplete"
  />
</template>

<script>
export default {
  name: 'TextInput',
  props: {
    modelValue: String,
    id: String,
    type: {
      type: String,
      default: 'text'
    },
    name: String,
    autocomplete: String,
  },
};
</script>
