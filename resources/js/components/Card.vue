<template>
  <div class="card">
    <div
      v-if="title"
      class="card-header"
    >
      {{ title }}

      <el-button
        v-if="canGoBack"
        class="float-right"
        type="info"
        size="mini"
        @click="goBack"
      >Go Back</el-button>
    </div>

    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: "Card",

  props: {
    title: { type: String, default: null },
    page: { type: Number, default: null }
  },

  computed: {
    canGoBack() {
      return !!this.$route.query.page && this.$route.name !== "subscribers";
    }
  },

  methods: {
    goBack() {
      this.$router.push({
        name: "subscribers",
        query: {
          page: this.$route.query.page
        }
      });
    }
  }
};
</script>
