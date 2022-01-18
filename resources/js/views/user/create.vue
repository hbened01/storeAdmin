<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create User</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create User</li>
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
            <router-link class="btn btn-info btn-sm" :to="'/user'">
              Back <i class="fas fa-arrow-left"></i>
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Create User Form</h3>
              </div>
              <div class="card-body">
                <form role="form">
                  <div class="row">
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">First Name</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillCreateUser.firstname"
                          @keyup.enter="setRegisterUser"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Second Name</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillCreateUser.secondname"
                          @keyup.enter="setRegisterUser"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Last Name</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillCreateUser.lastname"
                          @keyup.enter="setRegisterUser"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">User</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillCreateUser.user"
                          @keyup.enter="setRegisterUser"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Email</label>
                      <div class="col-md-9">
                        <input
                          type="email"
                          class="form-control"
                          v-model="fillCreateUser.email"
                          @keyup.enter="setRegisterUser"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Password</label>
                      <div class="col-md-9">
                        <el-input
                          placeholder="Please input password"
                          v-model="fillCreateUser.password"
                          @keyup.enter="setRegisterUser"
                          show-password
                        ></el-input>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Photography</label>
                      <div class="col-md-9">
                        <input
                          type="file"
                          class="form-control"
                          @change="getFile"
                        />
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4 style-inline-1">
                    <button
                      class="btn btn-flat btn-info btn-width"
                      @click.prevent="setRegisterUser"
                      v-loading.fullscreen.lock="fullscreenLoading"
                    >
                      Add New
                    </button>
                    <button
                      class="btn btn-flat btn-default btn-width"
                      @click.prevent="clearFormUser"
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
      fillCreateUser: {
        firstname: "",
        secondname: "",
        lastname: "",
        user: "",
        email: "",
        password: "",
        photography: "",
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
      form: new FormData(),
      fullscreenLoading: false,
    };
  },
  computed: {},
  methods: {
    setRegisterUser() {
      if (this.validateUserForm()) {
        this.modalShow = true;
        return true;
      }
      this.fullscreenLoading = true;
      if (
        !this.fillCreateUser.photography ||
        this.fillCreateUser.photography == undefined
      ) {
        this.setSaveUser();
      } else {
        this.setRegisterFile();
      }
    },
    setRegisterFile() {
      this.form.append("file", this.fillCreateUser?.photography);
      const config = { headers: { "content-type": "multiport/form-data" } };
      const url = "/file/setRegisterFile";
      axios.post(url, this.form, config).then((response) => {
        const idFile = response?.data[0]?.idFile;
        this.setSaveUser(idFile);
      });
    },
    setSaveUser(idFile = null) {
      const url = "/admin/user/setRegisterUser";
      axios
        .post(url, {
          firstname: this.fillCreateUser?.firstname,
          secondname: this.fillCreateUser?.secondname,
          lastname: this.fillCreateUser?.lastname,
          user: this.fillCreateUser?.user,
          email: this.fillCreateUser?.email,
          password: this.fillCreateUser?.password,
          photography: idFile,
        })
        .then((response) => {
          this.fullscreenLoading = false;
          this.$router.push("/user");
        });
    },
    getFile(e) {
      this.fillCreateUser.photography = e.target.files[0];
    },
    openModal() {
      this.modalShow = !this.modalShow;
    },
    closedModal() {
      this.modalShow = !this.modalShow;
    },
    validateUserForm() {
      this.error = 0;
      this.messageError = [];
      if (!this.fillCreateUser?.firstname) {
        this.messageError.push('"Firts Name" <strong>is obligatory</strong>');
      }
      if (!this.fillCreateUser?.secondname) {
        this.messageError.push('"Second Name" <strong>is obligatory</strong>');
      }
      if (!this.fillCreateUser?.lastname) {
        this.messageError.push('"Last Name" <strong>is obligatory</strong>');
      }
      if (!this.fillCreateUser?.user) {
        this.messageError.push('"User" <strong>is obligatory</strong>');
      }
      if (!this.fillCreateUser?.email) {
        this.messageError.push('"Email" <strong>is obligatory</strong>');
      }
      if (!this.fillCreateUser?.password) {
        this.messageError.push('"Password" <strong>is obligatory</strong>');
      }
      if (!this.fillCreateUser?.photography) {
        this.messageError.push('"Password" <strong>is obligatory</strong>');
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
    clearFormUser() {
      this.fillCreateUser.firstname = "";
      this.fillCreateUser.secondname = "";
      this.fillCreateUser.lastname = "";
      this.fillCreateUser.user = "";
      this.fillCreateUser.email = "";
      this.fillCreateUser.password = "";
      this.fillCreateUser.photography = "";
    },
  },
};
</script>
<style></style>
