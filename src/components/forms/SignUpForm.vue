<template>
  <h4 class="form__title">{{ title }}</h4>
  <form class="form__login form" @submit.prevent>
    <label for="email">
      <InputBase
        v-model="registry.email"
        class="form__input email"
        placeholder="Email"
        type="text"
      />
    </label>
    <label for="name">
      <InputBase
        v-model="registry.name"
        class="form__input name"
        placeholder="Имя"
        type="text"
      />
    </label>
    <label for="password">
      <InputBase
        v-model="registry.password"
        class="form__input password"
        placeholder="Пароль"
        type="password"
      />
    </label>
    <ButtonBase class="red" type="button">Зарегистрироваться</ButtonBase>
    <router-link :to="{ name: 'sign_in' }" class="form-link-red"
      >Войти
    </router-link>
  </form>
</template>

<script>
import { defineComponent } from "vue";
import InputBase from "@/components/Ui/InputBase";

export default defineComponent({
  name: "RegistryForm",
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
