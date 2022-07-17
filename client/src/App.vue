<template>
  <HeaderApp></HeaderApp>
  <router-view v-slot="{ Component }">
    <PageTransition>
      <component :is="Component" />
    </PageTransition>
  </router-view>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import HeaderApp from "@/components/app/HeaderApp.vue";
import "@/assets/styles/style.scss";
import PageTransition from "@/components/transitions/PageTransition.vue";

export default defineComponent({
  name: "App",
  components: {
    HeaderApp,
    PageTransition,
  },
});
</script>

<style lang="scss"></style>
