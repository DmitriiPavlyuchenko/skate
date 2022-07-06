<template>
  <li class="news-item">
    <img alt="" class="news-item__picture" src="" />
    <div class="news-item__body">
      <h3 class="news-item__title">{{ newsItem.title }}</h3>
      <p class="news-item__text">{{ newsItem.text }}</p>
    </div>
    <div class="news-item__aside">
      <div class="news-item__buttons">
        <router-link
          :to="{ name: 'newsOpen', params: { id: newsItem.createdAt } }"
          class="news-item__open dark-green"
          >Открыть
        </router-link>
        <ButtonBase class="news-item__delete red">Удалить</ButtonBase>
      </div>
      <span class="news-item__date">{{ newsItem.createdAt }}</span>
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
};
</script>

<style scoped></style>
