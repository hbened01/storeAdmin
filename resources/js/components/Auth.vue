<template>
  <!-- Content Wrapper -->
  <div class="login-page">
    <transition name="slide-fade" mode="out-in">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
export default {
  name: "Auth",
  components: {},
  mixins: [],
  data() {
    return {};
  },
  created() {},
  mounted() {},
  methods: {},
};
</script>
