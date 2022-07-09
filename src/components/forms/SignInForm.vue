<template>
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
      authorization: {
        email: "",
        password: "",
      },
    };
  },

  methods: {},
});
</script>

<style scoped></style>
