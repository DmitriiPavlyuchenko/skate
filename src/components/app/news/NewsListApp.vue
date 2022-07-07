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

export default {
  name: "NewsListApp",
  components: { NewsItemApp },
  props: {
    news: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped></style>
