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
  watch: {
    newsItem(newValue) {
      this.newsItem.createdAt = newValue.createdAt
        .split(" ")
        .slice(0, 1)
        .toString();
    },
  },
  methods: {
    async getNewsItemInformation() {
      try {
        const URL = API.newsPath;
        const newsId = this.id;
        const response = await getNewsItemInformation(URL, newsId);
        if (response.status === STATUS_CODE.SUCCESS) {
          this.newsItem = response.data;
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
});
</script>

<style scoped></style>
