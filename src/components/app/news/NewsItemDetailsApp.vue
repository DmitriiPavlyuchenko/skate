<template>
  <div class="news">
    <div class="news__container container"></div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import { getNewsItemInformation } from "@/api/news";
import { API } from "@/constants/api";

export default defineComponent({
  name: "NewsItemOpenApp",
  data() {
    return {
      id: this.$route.params.id,
    };
  },
  created() {
    this.getNewsItemInformation();
  },
  methods: {
    async getNewsItemInformation() {
      try {
        const URL = API.newsPath;
        const newsId = this.id;
        const response = await getNewsItemInformation(URL, newsId);
        console.log(response.data);
      } catch (error) {
        console.log(error);
      }
    },
  },
});
</script>

<style scoped></style>
