<template>
  <input :value="modelValue" class="input" @input="updateValue" />
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
  },
  emits: ["update: modelValue"],
  methods: {
    updateValue(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
});
</script>

<style scoped></style>
