<template>
  <HeaderApp></HeaderApp>
  <router-view></router-view>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import HeaderApp from "@/components/app/HeaderApp.vue";
import "@/assets/styles/style.scss";

export default defineComponent({
  name: "App",
  components: {
    HeaderApp,
  },
});
</script>

<style lang="scss"></style>
