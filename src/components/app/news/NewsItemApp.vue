<template>
  <li class="news-item">
    <img alt="" class="news-item__picture" src="@/assets/img/header/Logo.png" />
    <div class="news-item__body">
      <h3 class="news-item__title">{{ newsItem.title }}</h3>
      <p class="news-item__text">{{ newsItem.text }}</p>
    </div>
    <div class="news-item__aside">
      <div class="news-item__buttons">
        <router-link
          :to="{
            name: 'newsOpen',
            params: { id: newsItem.uuid },
          }"
          class="news-item__open dark-green"
          >Открыть
        </router-link>
        <ButtonBase class="news-item__delete red">Удалить</ButtonBase>
      </div>
      <span class="news-item__date">{{ newsItem.creadAt }}</span>
    </div>
  </li>
</template>

<script>
import ButtonBase from "@/components/Ui/ButtonBase";

export default {
  name: "NewsItemApp",
  components: { ButtonBase },
  props: {
    newsItem: {
      type: Object,
      required: true,
    },
  },
  computed: {},
};
</script>

<style scoped></style>
