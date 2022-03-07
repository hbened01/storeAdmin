<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create Permit</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Permit</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <div class="content container-fluid">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/permit'">
              Back <i class="fas fa-arrow-left"></i>
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Create Permit Form</h3>
              </div>
              <div class="card-body">
                <form role="form">
                  <div class="row">
                    <div class="col-md-12">
                      <label class="col-md-3 col-form-label">Name</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillCreatePermit.name"
                          @keyup.enter="setRegisterPermit"
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label class="col-md-3 col-form-label">Url</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillCreatePermit.slug"
                          @keyup.enter="setRegisterPermit"
                        />
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="col-md-4 offset-4">
                  <button
                    class="btn btn-flat btn-info"
                    @click.prevent="setRegisterPermit"
                    v-loading.fullscreen.lock="fullscreenLoading"
                  >
                    Add New
                  </button>
                  <button
                    class="btn btn-flat btn-default"
                    @click.prevent="clearFormRole"
                  >
                    Clear
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      :class="['modal', 'fade', { show: modalShow }]"
      :style="modalShow ? viewModal : hideModal"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Store Admin</h5>
            <button class="close" @click="openModal"></button>
          </div>
          <div class="modal-body">
            <div
              class="callout callout-danger"
              style="padding: 5px"
              v-for="(item, key) in messageError"
              :key="key"
              v-html="item"
            ></div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" @click="closedModal">
              Closed
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "Users",
  props: {},
  mixins: [],
  data() {
    return {
      fillCreatePermit: {
        name: "",
        slug: "",
      },
      modalShow: false,
      viewModal: {
        display: "block",
        background: "#00000006b",
      },
      hideModal: {
        display: "none",
      },
      error: 0,
      messageError: [],
      fullscreenLoading: false,
    };
  },
  computed: {},
  methods: {
    setRegisterPermit() {
      const url = "/admin/permit/setRegisterPermit";
      if (this.ValidatePermitForm()) {
        this.modalShow = true;
        return true;
      }
      this.fullscreenLoading = true;
      axios
        .post(url, {
          name: this.fillCreatePermit?.name,
          slug: this.fillCreatePermit?.slug,
        })
        .then((response) => {
          this.fullscreenLoading = false;
          Swal.fire({
            icon: "success",
            title: "Create permit successfully!!",
            showConfirmButton: false,
            timer: 1500,
          });
          this.$router.push("/permit");
        });
    },
    openModal() {
      this.modalShow = !this.modalShow;
    },
    closedModal() {
      this.modalShow = !this.modalShow;
    },
    ValidatePermitForm() {
      let count = 0;
      this.error = 0;
      this.messageError = [];
      if (!this.fillCreatePermit?.name) {
        this.messageError.push('"Name" <strong>is obligatory</strong>');
      }
      if (!this.fillCreatePermit?.slug) {
        this.messageError.push('"Friendly Url" <strong>is obligatory</strong>');
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
    clearFormRole() {
      this.fillCreatePermit.name = "";
      this.fillCreatePermit.slug = "";
    },
  },
  mounted() {},
};
</script>
<style></style>
