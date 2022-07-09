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
              >Новости
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'series' }" class="nav-menu__link"
              >Серии
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'skaters' }" class="nav-menu__link"
              >Скейтеры
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'brands' }" class="nav-menu__link"
              >Бренды
            </router-link>
          </li>
          <li class="nav-menu__item">
            <router-link :to="{ name: 'videos' }" class="nav-menu__link"
              >Видео
            </router-link>
          </li>
        </ul>
        <MobileTransition name="mobile-menu">
          <ul
            v-show="isMobileNav"
            class="nav-menu__mobile-list"
            @click="isMobileNav = false"
          >
            <li class="nav-menu__mobile-item">
              <router-link :to="{ name: 'news' }" class="nav-menu__mobile-link"
                >Новости
              </router-link>
            </li>
            <li class="nav-menu__mobile-item">
              <router-link
                :to="{ name: 'series' }"
                class="nav-menu__mobile-link"
                >Серии
              </router-link>
            </li>
            <li class="nav-menu__mobile-item">
              <router-link
                :to="{ name: 'skaters' }"
                class="nav-menu__mobile-link"
                >Скейтеры
              </router-link>
            </li>
            <li class="nav-menu__mobile-item">
              <router-link
                :to="{ name: 'brands' }"
                class="nav-menu__mobile-link"
                >Бренды
              </router-link>
            </li>
            <li class="nav-menu__mobile-item">
              <router-link
                :to="{ name: 'videos' }"
                class="nav-menu__mobile-link"
                >Видео
              </router-link>
            </li>
            <li class="nav-menu__mobile-item">
              <router-link
                :to="{ name: 'sign_in' }"
                class="nav-menu__mobile-link"
                >Личный кабинет
              </router-link>
            </li>
          </ul>
        </MobileTransition>
      </nav>
      <div class="header__burger">
        <button
          class="header__burger-button"
          type="button"
          @click="isMobileNav ? (isMobileNav = false) : (isMobileNav = true)"
        >
          <span :class="isMenuClassActive"></span>
          <span class="header__burger-item"></span>
          <span :class="isMenuClassActive"></span>
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
import MobileTransition from "@/components/transitions/MobileTransition.vue";

export default defineComponent({
  name: "HeaderApp",
  components: {
    MobileTransition,
  },
  data() {
    return {
      isMobile: false,
      isMobileNav: false,
      windowWidth: 0,
    };
  },
  created() {
    window.addEventListener("resize", this.checkScreen);
  },
  computed: {
    isMenuClassActive: function (): object {
      return {
        "header__burger-item": !this.isMobileNav,
        "header__burger-item_active": this.isMobileNav,
      };
    },
  },
  methods: {
    checkScreen() {
      this.windowWidth = window.innerWidth;
      if (this.windowWidth <= 780) {
        this.isMobile = true;
        return;
      } else {
        this.isMobile = false;
        this.isMobileNav = false;
        return;
      }
    },
  },
});
</script>

<style lang="scss" scoped></style>
