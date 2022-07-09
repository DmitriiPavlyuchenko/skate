<template>
  <DefaultModal>
    <template #title>
      <h3 class="form__title">{{ title }}</h3>
    </template>
    <template #form>
      <SignInForm></SignInForm>
    </template>
    <template #buttons>
      <ButtonBase>Войти</ButtonBase>
      <router-link :to="{ name: 'sign_up' }">Регистрация</router-link>
    </template>
  </DefaultModal>
</template>

<script>
import { defineComponent } from "vue";
import SignInForm from "@/components/forms/SignInForm";
import DefaultModal from "@/components/modals/DefaultModal";

export default defineComponent({
  name: "SignInModal",
  components: { SignInForm, DefaultModal },
  data() {
    return {
      title: "Авторизация",
    };
  },
});
</script>

<style scoped></style>
