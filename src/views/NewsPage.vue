<template>
  <div class="news">
    <div class="news__container container">
      <h1 class="news__title page-title">Новости</h1>
      <NewsListApp></NewsListApp>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import NewsListApp from "@/components/app/news/NewsListApp";

export default defineComponent({
  name: "NewsPage",
  components: { NewsListApp },
});
</script>

<style scoped></style>
