<template>
  <h4 class="form__title">{{ title }}</h4>
  <form class="form__login form" @submit.prevent>
    <div class="form__element">
      <label class="form__label" for="email"></label>
      <InputBase
        v-model="authorization.email"
        class="form__input username"
        name="email"
        placeholder="Email"
        type="text"
      />
    </div>
    <div class="form__element">
      <label class="form__label" for="password"></label>
      <InputBase
        v-model="authorization.password"
        class="form__input password"
        name="password"
        placeholder="Пароль"
        type="password"
      />
    </div>

    <ButtonBase class="red form__button" type="button">Войти</ButtonBase>
    <router-link :to="{ name: 'sign_up' }" class="form-link-red"
      >Зарегистрироваться
    </router-link>
  </form>
</template>

<script>
import { defineComponent } from "vue";
import InputBase from "@/components/Ui/InputBase";

export default defineComponent({
  name: "SignInForm",
  components: { InputBase },
  data() {
    return {
      title: "Авторизация",
      authorization: {
        email: "",
        password: "",
      },
    };
  },
});
</script>

<style scoped></style>
