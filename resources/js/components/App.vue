<template>
  <div>
    <!-- Preloader -->
    <div
      class="preloader flex-column justify-content-center align-items-center"
    >
      <img
        class="animation__shake"
        src="#"
        alt="AdminLTELogo"
        height="60"
        width="60"
      />
    </div>

    <!-- Navbar -->
    <nav-bar :base-path="basePath" />
    <!-- /.Navbar -->

    <!-- Main Sidebar Container -->
    <side-bar :base-path="basePath" />
    <!-- /.Main Sidebar Container -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <transition name="slide-fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
    <!-- <content-wrapper :base-path="basePath" /> -->
    <!-- /.Content-wrapper -->

    <!-- Footer -->
    <footer-page :base-path="basePath" />
    <!-- /.Footer -->
  </div>
</template>

<script>
import NavBar from "./templates/NavBar";
import SideBar from "./templates/SideBar";
// import ContentWrapper from "./template/ContentWrapper";
import FooterPage from "./templates/FooterPage";
export default {
  name: "App",
  props: {
    basePath: {
      type: String,
      required: true,
      default: "",
    },
  },
  components: {
    NavBar,
    SideBar,
    FooterPage,
  },
  mixins: [],
  data() {
    return {};
  },
  created() {},
  mounted() {
    // console.log("Component mounted.");
    // console.log(this.basePath);
    $.widget.bridge("uibutton", $.ui.button);
  },
  methods: {},
};
</script>
