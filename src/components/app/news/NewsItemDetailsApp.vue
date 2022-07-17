<template>
  <div class="news-details">
    <div class="news-details__container container">
      <h3 class="news-details__title page-title">{{ newsItem.title }}</h3>
      <span class="news-details__text">{{ newsItem.text }}</span>
      <span class="news-details__date">{{ newsItem.createdAt }}</span>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import { getNewsItemInformation } from "@/api/news";
import { API } from "@/constants/api";
import { STATUS_CODE } from "@/constants/status-code";
import { DEFAULT_ERROR_TOAST_CONFIG, TOAST_MESSAGE } from "@/constants/toast";

export default defineComponent({
  name: "NewsItemOpenApp",
  data() {
    return {
      id: this.$route.params.id,
      newsItem: {},
    };
  },
  created() {
    this.getNewsItemInformation();
  },
  watch: {},
  methods: {
    async getNewsItemInformation() {
      try {
        const URL = API.newsPath;
        const newsId = this.id;
        const response = await getNewsItemInformation(URL, newsId);
        if (response.status === STATUS_CODE.SUCCESS) {
          this.newsItem = response.data;
        }
      } catch {
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
