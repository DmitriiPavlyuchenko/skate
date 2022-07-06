<template>
  <div class="news">
    <div class="news__container container">
      <h1 class="news__title page-title">Новости</h1>
      <ul class="news"></ul>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import { API, STATUS_CODE } from "@/constants/api";
import { getNews } from "@/api/news";

export default defineComponent({
  name: "NewsPage",
  data() {
    return {
      news: [],
    };
  },
  created() {
    this.getNews();
  },
  methods: {
    async getNews() {
      try {
        const URL = API.newsPath;
        const response = await getNews(URL);
        if (response.status === STATUS_CODE.SUCCESS) {
          this.news = response.data;
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
});
</script>

<style scoped></style>
