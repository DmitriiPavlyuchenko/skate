<template>
  <ul class="news__list">
    <NewsItemApp
      v-for="newsItem in news"
      :key="newsItem.uuid"
      :newsItem="newsItem"
    ></NewsItemApp>
  </ul>
</template>

<script>
import NewsItemApp from "@/components/app/news/NewsItemApp";
import { API } from "@/constants/api";
import { getNews } from "@/api/news";
import { DEFAULT_ERROR_TOAST_CONFIG, TOAST_MESSAGE } from "@/constants/toast";
import { STATUS_CODE } from "@/constants/status-code";

export default {
  name: "NewsListApp",
  components: { NewsItemApp },
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
        this.$toast.show(
          TOAST_MESSAGE.ERROR_RESPONSE,
          DEFAULT_ERROR_TOAST_CONFIG
        );
      }
    },
  },
};
</script>

<style scoped></style>
