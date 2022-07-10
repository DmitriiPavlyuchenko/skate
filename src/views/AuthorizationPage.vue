<template>
  <div class="authorization">
    <div class="authorization__container container">
      <div class="authorization__wrapper">
        <div class="authorization__form">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AuthorizationPage",
};
</script>

<style scoped></style>
