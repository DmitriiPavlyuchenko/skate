<template>
  <transition>
    <slot></slot>
  </transition>
</template>

<script>
export default {
  name: "MobileTransition",
};
</script>

<style lang="scss" scoped>
.mobile-menu-enter-active,
.mobile-menu-leave-active {
  transition: 0.5s ease all;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
  transform: translateX(100%);
}

.mobile-menu-enter-to {
  transform: translateX(0);
}
</style>
