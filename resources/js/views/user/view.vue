<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <div class="content container-fluid">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <template v-if="!fillViewUser.profileImage">
                  <img
                    src="/img/avatar.png"
                    :alt="getFullName"
                    class="profile-user-img img-fluid img-circle img-max-height"
                  />
                </template>
                <template v-else>
                  <img
                    :src="fillViewUser.profileImage"
                    :alt="getFullName"
                    class="profile-user-img img-fluid img-circle img-max-height"
                  />
                </template>
              </div>
              <h3 class="profile-username text-center">{{ getFullName }}</h3>
              <p class="text-muted text-center">{{ fillViewUser.nameRol }}</p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">About Me</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fab fa-mailchimp"></i> Full Name</strong>
              <p class="text-muted" v-text="getFullName"></p>
              <hr />
              <strong><i class="fas fa-envelope-square"></i> Email</strong>
              <p class="text-muted" v-text="fillViewUser.email"></p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills position-reverse">
                <li class="nav-item">
                  <router-link class="nav-link active" to="/user">
                    <i class="fas fa-arrow-circle-left"></i> Return</router-link
                  >
                </li>
              </ul>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="settings">
                  <form class="form-horizontal">
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label">First Name</label>
                      <div class="col-md-8">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillEditUser.firstname"
                          @keyup.enter="setEditUser"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label">Second Name</label>
                      <div class="col-md-8">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillEditUser.secondname"
                          @keyup.enter="setEditUser"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label">Last Name</label>
                      <div class="col-md-8">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillEditUser.lastname"
                          @keyup.enter="setEditUser"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label">User</label>
                      <div class="col-md-8">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillEditUser.user"
                          @keyup.enter="setEditUser"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label">Email</label>
                      <div class="col-md-8">
                        <input
                          type="email"
                          class="form-control"
                          v-model="fillEditUser.email"
                          @keyup.enter="setEditUser"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label">Password</label>
                      <div class="col-md-8">
                        <el-input
                          placeholder="Please input password"
                          v-model="fillEditUser.password"
                          @keyup.enter="setEditUser"
                          show-password
                        ></el-input>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label">Photography</label>
                      <div class="col-md-8">
                        <input
                          type="file"
                          class="form-control"
                          @change="getFile"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <button
                          class="btn btn-flat btn-info btn-width button-full"
                          @click.prevent="setEditUser"
                          v-loading.fullscreen.lock="fullscreenLoading"
                        >
                          Update
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      fillEditUser: {
        idUser: this.$attrs.id,
        firstname: "",
        secondname: "",
        lastname: "",
        user: "",
        email: "",
        password: "",
        photography: "",
        profileImage: "",
      },
      fillViewUser: {
        idUser: this.$attrs.id,
        firstname: "",
        secondname: "",
        lastname: "",
        user: "",
        email: "",
        password: "",
        photography: "",
        profileImage: "",
        nameRol: "",
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
  computed: {
    getFullName() {
      return (
        this.fillViewUser?.firstname +
        "" +
        this.fillViewUser?.secondname +
        "" +
        this.fillViewUser?.lastname
      );
    },
  },
  methods: {
    getUserById() {
      this.fullscreenLoading = true;
      let url = `/admin/user/getListUsers`;
      axios
        .get(url, {
          params: {
            id: this.fillEditUser.idUser,
          },
        })
        .then((response) => {
          this.fullscreenLoading = false;
          this.getUserEdit(response.data[0]);
          this.getUserView(response.data[0]);
        });
    },
    getUserEdit(data) {
      this.fillEditUser.firstname = data.firstname;
      this.fillEditUser.secondname = data.secondname;
      this.fillEditUser.lastname = data.lastname;
      this.fillEditUser.user = data.username;
      this.fillEditUser.email = data.email;
      this.fillEditUser.profileImage = data.profile_image;
    },
    getUserView(data) {
      this.fillViewUser.firstname = data.firstname;
      this.fillViewUser.secondname = data.secondname;
      this.fillViewUser.lastname = data.lastname;
      this.fillViewUser.user = data.username;
      this.fillViewUser.email = data.email;
      this.fillViewUser.profileImage = data.profile_image;
    },
    openModal() {
      this.modalShow = !this.modalShow;
    },
    closedModal() {
      this.modalShow = !this.modalShow;
    },
    setEditUser() {
      if (this.validateUserForm()) {
        this.modalShow = true;
        return true;
      }
      this.fullscreenLoading = true;
      if (
        !this.fillEditUser.photography ||
        this.fillEditUser.photography == undefined
      ) {
        this.setSaveUser();
      } else {
        this.setRegisterFile();
      }
    },
    setRegisterFile() {
      this.form.append("file", this.fillEditUser?.photography);
      const config = { headers: { "content-type": "multiport/form-data" } };
      const url = "/file/setRegisterFile";
      axios.post(url, this.form, config).then((response) => {
        const idFile = response?.data[0]?.idFile;
        this.setSaveUser(idFile);
      });
    },
    getRoleByUser() {
      this.fullscreenLoading = true;
      let url = `/admin/user/getRoleByUser`;
      axios
        .get(url, {
          params: {
            idUser: this?.fillViewUser?.idUser,
          },
        })
        .then((response) => {
          this.fillViewUser.nameRol =
            response.data.length !== 0 ? response.data[0].name : null;
          // this.listRoles = response.data;
          this.fullscreenLoading = false;
        });
    },
    setSaveUser(idFile = null) {
      const url = "/admin/user/setEditUser";
      axios
        .post(url, {
          id: this.fillEditUser?.idUser,
          firstname: this.fillEditUser?.firstname,
          secondname: this.fillEditUser?.secondname,
          lastname: this.fillEditUser?.lastname,
          user: this.fillEditUser?.user,
          email: this.fillEditUser?.email,
          password: this.fillEditUser?.password,
          photography: idFile,
        })
        .then((response) => {
          this.fullscreenLoading = false;
          this.getUserById();
          Swal.fire({
            icon: "success",
            title: "Update user successfully!!",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
    getFile(e) {
      this.fillEditUser.photography = e.target.files[0];
    },
    validateUserForm() {
      this.error = 0;
      this.messageError = [];
      if (!this.fillEditUser?.firstname) {
        this.messageError.push('"Firts Name" <strong>is obligatory</strong>');
      }
      if (!this.fillEditUser?.secondname) {
        this.messageError.push('"Second Name" <strong>is obligatory</strong>');
      }
      if (!this.fillEditUser?.lastname) {
        this.messageError.push('"Last Name" <strong>is obligatory</strong>');
      }
      if (!this.fillEditUser?.user) {
        this.messageError.push('"User" <strong>is obligatory</strong>');
      }
      if (!this.fillEditUser?.email) {
        this.messageError.push('"Email" <strong>is obligatory</strong>');
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
  },
  mounted() {
    this.getUserById();
    this.getRoleByUser();
  },
};
</script>

<style>
    .position-reverse {
        flex-direction: row-reverse !important;
    }

    .img-max-height {
        max-height: 100px !important;
    }
</style>
