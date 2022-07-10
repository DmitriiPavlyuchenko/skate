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

    <ButtonBase class="red form__button" type="button" @click="signIn"
      >Войти
    </ButtonBase>
    <router-link :to="{ name: 'sign_up' }" class="form-link-red"
      >Зарегистрироваться
    </router-link>
  </form>
</template>

<script>
import { defineComponent } from "vue";
import InputBase from "@/components/Ui/InputBase";
import { API } from "@/constants/api";
import { signIn } from "@/api/authorization";
import { DEFAULT_ERROR_TOAST_CONFIG, TOAST_MESSAGE } from "@/constants/toast";

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
  methods: {
    async signIn() {
      try {
        const URL = API.signInPath;
        const data = {
          email: this.authorization.email,
          password: this.authorization.password,
        };
        const response = await signIn(URL, data);
        console.log(response);
      } catch (error) {
        this.$toast.show(
          TOAST_MESSAGE.ERROR_RESPONSE,
          DEFAULT_ERROR_TOAST_CONFIG
        );
      }
    },
  },
});
</script>

<style scoped></style>
