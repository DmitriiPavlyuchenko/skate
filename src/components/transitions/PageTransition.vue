<template>
  <transition
    enter-active-class="animate__animated animate__fadeInLeft"
    leave-active-class="animate__animated animate__fadeOutLeft"
    mode="out-in"
    name="page"
  >
    <slot></slot>
  </transition>
</template>

<script>
import "animate.css";

export default {
  name: "PageTransition",
};
</script>

<style scoped></style>
