<template>
  <h4 class="form__title">{{ $options.title }}</h4>
  <form class="form__login form" @submit.prevent>
    <div class="form__element">
      <label class="form__label" for="email"></label>
      <InputBase
        v-model="registry.email"
        class="form__input email"
        name="email"
        placeholder="Email"
        type="text"
        @blur="v$.registry.email.$touch"
      />
      <span v-if="v$.registry.email.$error" class="form__error">
        {{ $options.requiredFieldErrorMessage }}
      </span>
    </div>
    <div class="form__element">
      <label class="form__label" for="name"></label>
      <InputBase
        v-model.capitalize="registry.username"
        class="form__input username"
        name="name"
        placeholder="Имя"
        type="text"
        @blur="v$.registry.username.$touch"
      />
      <span v-if="v$.registry.username.$error" class="form__error">
        {{ $options.requiredFieldErrorMessage }}
      </span>
    </div>
    <div class="form__element">
      <label class="form__label" for="password"></label>
      <InputBase
        v-model="registry.password"
        class="form__input password"
        name="password"
        placeholder="Пароль"
        type="password"
        @blur="v$.registry.password.$touch"
      />
      <span v-if="v$.registry.password.$error" class="form__error">
        {{ $options.requiredFieldErrorMessage }}
      </span>
    </div>
    <ButtonBase class="red form__button" type="submit" @click="signUp"
      >Зарегистрироваться
    </ButtonBase>
    <router-link :to="{ name: 'sign_in' }" class="form-link-red"
      >Войти
    </router-link>
  </form>
</template>

<script>
import { defineComponent } from "vue";
import { minLength, required } from "@vuelidate/validators";
import InputBase from "@/components/Ui/InputBase";
import { DEFAULT_ERROR_TOAST_CONFIG, TOAST_MESSAGE } from "@/constants/toast";
import { API } from "@/constants/api";
import { signUp } from "@/api/authorization";
import useVuelidate from "@vuelidate/core";
import { ERROR_MESSAGE } from "@/constants/vuelidate-messages";

export default defineComponent({
  name: "SignUpForm",
  components: { InputBase },
  title: "Регистрация",
  requiredFieldErrorMessage: ERROR_MESSAGE.REQUIRED,
  data() {
    return {
      registry: {
        email: "",
        username: "",
        password: "",
      },
      v$: useVuelidate(),
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
      } catch {
        this.$toast.show(
          TOAST_MESSAGE.ERROR_RESPONSE,
          DEFAULT_ERROR_TOAST_CONFIG
        );
      }
    },
  },
  validations() {
    return {
      registry: {
        email: { required },
        username: { required },
        password: { required, minLength: minLength(6) },
      },
    };
  },
});
</script>

<style scoped></style>
