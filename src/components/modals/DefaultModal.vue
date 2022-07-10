<template>
  <teleport to="body">
    <div class="modal">
      <div class="modal__overlay"></div>
      <div class="modal__container">
        <div class="modal__wrapper">
          <div class="modal__title">
            <slot name="title"></slot>
          </div>
          <div class="modal__form">
            <slot name="form"></slot>
          </div>
          <div class="modal__buttons">
            <slot name="buttons"></slot>
          </div>
          <button class="modal__close icon-close" type="button"></button>
        </div>
      </div>
    </div>
  </teleport>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "DefaultModal",
});
</script>

<style lang="scss" scoped></style>
