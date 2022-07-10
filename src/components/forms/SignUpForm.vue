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
        v-model="registry.name"
        class="form__input name"
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
    <ButtonBase class="red form__button" type="button"
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

export default defineComponent({
  name: "SignUpForm",
  components: { InputBase },
  data() {
    return {
      title: "Регистрация",
      registry: {
        email: "",
        name: "",
        password: "",
      },
    };
  },
});
</script>

<style scoped></style>
