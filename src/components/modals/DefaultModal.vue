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
  components: {},
});
</script>

<style lang="scss" scoped>
.modal {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 1000;

  &__overlay {
    background: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: -1;
  }

  &__container {
    white-space: nowrap;
    height: 100%;
    outline: 0;
    overflow-x: hidden;
    overflow-y: auto;
    text-align: center;
  }

  &__wrapper {
    position: relative;
    width: 450px;
    padding: 48px 32px 32px;
    border-radius: 4px;
    color: #2d2928;
    box-shadow: 0 2px 8px rgb(49 50 56 / 10%);
    max-width: none;
    min-width: calc(300px - 2 * 20px);
    margin: 20px;
    white-space: normal;
    overflow: visible;
    display: inline-block;
    vertical-align: middle;
    background: #ffffff;
  }

  &__close {
    position: absolute;
    top: 10px;
    right: 10px;
  }
}

.icon-close {
  font-size: 14px;
  background-color: inherit;
  color: black;
}
</style>
