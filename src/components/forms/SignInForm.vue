<template>
  <h4 class="form__title">{{ $options.title }}</h4>
  <form class="form__login form" @submit.prevent>
    <div class="form__element">
      <label class="form__label" for="email"></label>
      <InputBase
        v-model="authorization.email"
        class="form__input email"
        name="email"
        placeholder="Email"
        type="text"
        @blur="v$.authorization.email.$touch"
      />
      <span v-if="v$.authorization.email.$error" class="form__error">{{
        $options.requiredFieldErrorMessage
      }}</span>
    </div>
    <div class="form__element">
      <label class="form__label" for="password"></label>
      <InputBase
        v-model="authorization.password"
        class="form__input password"
        name="password"
        placeholder="Пароль"
        type="password"
        @blur="v$.authorization.password.$touch"
      />
      <span v-if="v$.authorization.password.$error" class="form__error">{{
        $options.requiredFieldErrorMessage
      }}</span>
    </div>
    <ButtonBase class="red form__button" type="submit" @click="signIn"
      >Войти
    </ButtonBase>
    <router-link :to="{ name: 'sign_up' }" class="form-link-red"
      >Зарегистрироваться
    </router-link>
  </form>
</template>

<script>
import { defineComponent } from "vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import InputBase from "@/components/Ui/InputBase";
import { mapActions } from "vuex";
import { ERROR_MESSAGE } from "@/constants/vuelidate-messages";

export default defineComponent({
  name: "SignInForm",
  components: { InputBase },
  title: "Авторизация",
  requiredFieldErrorMessage: ERROR_MESSAGE.REQUIRED,
  data() {
    return {
      authorization: {
        email: "",
        password: "",
      },
      v$: useVuelidate(),
    };
  },
  methods: {
    ...mapActions({ signUser: "AuthModule/authorization" }),
    signIn() {
      this.signUser({
        email: this.authorization.email,
        password: this.authorization.password,
      });
    },
  },
  validations() {
    return {
      authorization: {
        email: { required },
        password: { required },
      },
    };
  },
});
</script>

<style scoped></style>
