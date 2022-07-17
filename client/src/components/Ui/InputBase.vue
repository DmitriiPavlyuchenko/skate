<template>
  <input :value="modelValue" class="input" @input="emitValue" />
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "InputBase",
  props: {
    modelValue: {
      type: String,
      required: true,
    },
    modelModifiers: {
      default: () => ({}),
    },
  },
  emits: ["update:modelValue"],
  methods: {
    emitValue(event) {
      let value = event.target.value;
      if (this.modelModifiers.capitalize) {
        value = value.charAt(0).toUpperCase() + value.slice(1);
      }
      this.$emit("update:modelValue", value);
    },
  },
});
</script>

<style scoped></style>
