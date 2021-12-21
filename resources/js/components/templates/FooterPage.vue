<template>
  <footer class="main-footer">
    <strong
      >Copyright &copy; 2014-2021
      <a href="https://adminlte.io">AdminLTE.io</a>.</strong
    >
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block"><b>Version</b> 3.1.0</div>
  </footer>
</template>
<script>
export default {
  name: "FooterPage",
  props: {
    basePath: {
      type: String,
      required: true,
      default: "",
    },
  },
  mixins: [],
  data() {
    return {};
  },
  created() {},
  methods: {},
};
</script>
<style></style>
