<template>
  <header class="header">
    <div class="header__container container">
      <div class="header__logo logo">
        <router-link :to="{ name: 'home' }" class="logo__link"
          ><img
            alt="logotype"
            class="logo__image"
            height="38"
            src="@/assets/img/header/Logo.png"
            width="287"
        /></router-link>
      </div>
      <nav class="header__menu nav-menu">
        <ul class="nav-menu__list">
          <li class="nav-menu__item">
            <router-link :to="{ name: 'news' }" class="nav-menu__link"
              >НОВОСТИ
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'series' }" class="nav-menu__link"
              >СЕРИИ
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'skaters' }" class="nav-menu__link"
              >СКЕЙТЕРЫ
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'brands' }" class="nav-menu__link"
              >БРЕНДЫ
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'videos' }" class="nav-menu__link"
              >ВИДЕО
            </router-link>
          </li>
        </ul>
      </nav>
      <div class="header__mobile-menu mobile-menu">
        <button
          class="mobile-menu__burger"
          type="button"
          @click="isActive ? (isActive = false) : (isActive = true)"
        >
          <span class="mobile-menu__item"></span>
          <span class="mobile-menu__item"></span>
          <span class="mobile-menu__item"></span>
        </button>
      </div>
      <div class="header__aside">
        <div class="header__authorization">
          <router-link :to="{ name: 'sign_in' }" class="header__login"
            >Личный кабинет
          </router-link>
        </div>
      </div>
    </div>
  </header>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "HeaderApp",
  data() {
    return {
      isActive: false,
    };
  },
  computed: {},
});
</script>

<style lang="scss" scoped></style>
