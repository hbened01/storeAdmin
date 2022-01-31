<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Role</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Role</li>
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
            <router-link class="btn btn-info btn-sm" :to="'/role'">
              Back <i class="fas fa-arrow-left"></i>
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-5">
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Edit Role Form</h3>
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
                              v-model="fillEditRole.name"
                              @keyup.enter="setRegisterRolePermit"
                            />
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label class="col-md-3 col-form-label">Url</label>
                          <div class="col-md-9">
                            <input
                              type="text"
                              class="form-control"
                              v-model="fillEditRole.slug"
                              @keyup.enter="setRegisterRolePermit"
                            />
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <button
                        class="btn btn-flat btn-info btn-width"
                        @click.prevent="setRegisterRolePermit"
                        v-loading.fullscreen.lock="fullscreenLoading"
                      >
                        Edit
                      </button>
                      <button
                        class="btn btn-flat btn-default btn-width"
                        @click.prevent="clearFormRole"
                      >
                        Clear
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">List Permits</h3>
                  </div>
                  <div class="card-body table-reponsive">
                    <template v-if="listPermissions.length">
                      <div class="scroll-table">
                        <table
                          class="
                            table table-hover table-head-fixed
                            text-nowrap
                            projects
                          "
                        >
                          <thead>
                            <tr>
                              <th>Action</th>
                              <th>Name</th>
                              <th>friendly Url</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(item, key) in listPermissionsFilter"
                              :key="key"
                              @click.prevent="checkRow(key)"
                            >
                              <td>
                                <el-checkbox
                                  v-model="item.checked"
                                ></el-checkbox>
                              </td>
                              <td v-text="item.name"></td>
                              <td v-text="item.slug"></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </template>
                    <template v-else>
                      <div class="callout callout-info text-center">
                        <h5>
                          No Data Information In Module Role
                          <i class="fas fa-info-circle"></i>
                        </h5>
                      </div>
                    </template>
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
      fillEditRole: {
        idRole: this.$attrs.id,
        name: "",
        slug: "",
      },
      listPermissions: [],
      listPermissionsFilter: [],
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
    setRegisterRolePermit() {
      const url = "/admin/role/setRegisterEditRolePermit";
      if (this.ValidateRoleForm()) {
        this.modalShow = true;
        return true;
      }
      this.fullscreenLoading = true;
      axios
        .post(url, {
          idRole: this.fillEditRole?.idRole,
          name: this.fillEditRole?.name,
          slug: this.fillEditRole?.slug,
          listPermissionsFilter: this.listPermissionsFilter,
        })
        .then((response) => {
          this.fullscreenLoading = false;
          Swal.fire({
            icon: "success",
            title: "Update role successfully!!",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
    getListPermissionsByRole() {
      const url = "/admin/role/getListPermissionsByRole";
      axios
        .get(url, {
          params: {
            idRole: this.fillEditRole?.idRole,
          },
        })
        .then((response) => {
          this.listPermissions = response.data;
          this.filterPermissionByRol();
        });
    },
    getlistRoles() {
      this.fullscreenLoading = true;
      let url = `/admin/role/getlistRoles`;
      axios
        .get(url, {
          params: {
            idRole: this.fillEditRole?.idRole,
          },
        })
        .then((response) => {
          this.fillEditRole.name = response.data[0].name;
          this.fillEditRole.slug = response.data[0].slug;
          this.fullscreenLoading = false;
        });
    },
    filterPermissionByRol() {
      let _this = this;
      this.listPermissionsFilter = _this.listPermissions.map((item, key) => {
        return {
          id: item.id,
          name: item.name,
          slug: item.slug,
          checked: item.checked ? true : false,
        };
      });
    },
    checkRow(i) {
      this.listPermissionsFilter[i].checked =
        !this.listPermissionsFilter[i].checked;
    },
    openModal() {
      this.modalShow = !this.modalShow;
    },
    closedModal() {
      this.modalShow = !this.modalShow;
    },
    ValidateRoleForm() {
      let count = 0;
      this.error = 0;
      this.messageError = [];
      this.listPermissionsFilter.forEach((item) => {
        if (item.checked) {
          count += 1;
        }
      });
      if (!this.fillEditRole?.name) {
        this.messageError.push('"Name" <strong>is obligatory</strong>');
      }
      if (!this.fillEditRole?.slug) {
        this.messageError.push('"Friendly Url" <strong>is obligatory</strong>');
      }
      if (count == 0) {
        this.messageError.push("You are have select one or more permissions!!");
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
    clearFormRole() {
      this.fillEditRole.name = "";
      this.fillEditRole.slug = "";
    },
  },
  mounted() {
    this.getListPermissionsByRole();
    this.getlistRoles();
  },
};
</script>
<style></style>
