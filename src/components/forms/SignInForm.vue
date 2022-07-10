<template>
  <h4 class="form__title">{{ title }}</h4>
  <form class="form__login form" @submit.prevent>
    <label for="email">
      <InputBase
        v-model="authorization.email"
        class="form__input username"
        placeholder="Email "
        type="text"
      />
    </label>
    <label for="password">
      <InputBase
        v-model="authorization.password"
        class="form__input password"
        placeholder="Пароль"
        type="password"
      />
    </label>
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
  name: "LoginForm",
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
