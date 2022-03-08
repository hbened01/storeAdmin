<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Asigns Permit</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Asigns Permit</li>
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
            <div class="row">
              <div class="col-md-5">
                <div class="col-md-7">
                  <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">
                        List Permits By Rol {{ fillPermit.nameRol }}
                      </h3>
                    </div>
                    <div class="card-body table-reponsive">
                      <template v-if="listPermitByRolAsign.length">
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
                                <th>Name</th>
                                <th>friendly Url</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr
                                v-for="(item, key) in listPermitByRolAsign"
                                :key="key"
                                @click.prevent="checkRow(key)"
                              >
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
                    <div class="card-footer">
                      <button
                        class="btn btn-flat btn-info btn-width"
                        @click.prevent="setRegisterRolePermitByUser"
                        v-loading.fullscreen.lock="fullscreenLoading"
                      >
                        Save
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
      fillPermit: {
        idUser: this.$attrs.id,
        nameRol: "",
      },
      listPermitByRolAsign: [],
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
    setRegisterRolePermitByUser() {
      const url = "/admin/user/setRegisterRolePermitByUser";
      if (this.validatePermitByUser()) {
        this.modalShow = true;
        return true;
      }
      this.fullscreenLoading = true;
      axios
        .post(url, {
          idUser: this.fillPermit?.idUser,
          listPermissionsFilter: this.listPermissionsFilter,
        })
        .then((response) => {
          this.fullscreenLoading = false;
          Swal.fire({
            icon: "success",
            title: "Update permit user successfully!!",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
    getListPermitByRolAsign() {
      const url = "/admin/user/getListPermitByRolAsign";
      axios
        .get(url, {
          params: {
            idUser: this?.fillPermit?.idUser,
          },
        })
        .then((response) => {
          this.listPermitByRolAsign = response.data;
        });
    },
    getRoleByUser() {
      this.fullscreenLoading = true;
      let url = `/admin/user/getRoleByUser`;
      axios
        .get(url, {
          params: {
            idUser: this?.fillPermit?.idUser,
          },
        })
        .then((response) => {
          this.fillPermit.nameRol =
            response.data.length !== 0 ? response.data[0].name : null;
          // this.listRoles = response.data;
          this.fullscreenLoading = false;
        });
    },
    getListPermissionsByUser() {
      const url = "/admin/user/getListPermissionsByUser";
      axios
        .get(url, {
          params: {
            idUser: this?.fillPermit?.idUser,
          },
        })
        .then((response) => {
          this.listPermissions = response.data;
          this.filterPermissionByUser();
        });
    },
    filterPermissionByUser() {
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
    validatePermitByUser() {
      let count = 0;
      this.error = 0;
      this.messageError = [];
      this.listPermissionsFilter.forEach((item) => {
        if (item.checked) {
          count += 1;
        }
      });
      if (count == 0) {
        this.messageError.push("You are have select one or more permissions!!");
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
    clearFormRole() {
      this.fillPermit.name = "";
      this.fillPermit.slug = "";
    },
  },
  mounted() {
    this.getListPermitByRolAsign();
    this.getListPermissionsByUser();
    this.getRoleByUser();
  },
};
</script>
<style></style>
