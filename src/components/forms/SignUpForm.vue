<template>
  <h4 class="form__title">{{ title }}</h4>
  <form class="form__login form" @submit.prevent>
    <div class="form__element">
      <label class="form__label" for="email"></label>
      <InputBase
        v-model="registry.email"
        class="form__input email"
        name="email"
        placeholder="Email"
        type="text"
      />
    </div>
    <div class="form__element">
      <label class="form__label" for="name"></label>
      <InputBase
        v-model.capitalize="registry.username"
        class="form__input username"
        name="name"
        placeholder="Имя"
        type="text"
      />
    </div>
    <div class="form__element">
      <label class="form__label" for="password"></label>
      <InputBase
        v-model="registry.password"
        class="form__input password"
        name="password"
        placeholder="Пароль"
        type="password"
      />
    </div>
    <ButtonBase class="red form__button" type="button" @click="signUp"
      >Зарегистрироваться
    </ButtonBase>
    <router-link :to="{ name: 'sign_in' }" class="form-link-red"
      >Войти
    </router-link>
  </form>
</template>

<script>
import { defineComponent } from "vue";
import InputBase from "@/components/Ui/InputBase";
import { API } from "@/constants/api";
import { signUp } from "@/api/authorization";
import { DEFAULT_ERROR_TOAST_CONFIG, TOAST_MESSAGE } from "@/constants/toast";

export default defineComponent({
  name: "SignUpForm",
  components: { InputBase },
  data() {
    return {
      title: "Регистрация",
      registry: {
        email: "",
        username: "",
        password: "",
      },
    };
  },
  methods: {
    async signUp() {
      try {
        const URL = API.signUpPath;
        const data = {
          email: this.registry.email,
          username: this.registry.username,
          password: this.registry.password,
        };
        const response = await signUp(URL, data);
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
