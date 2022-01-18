<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Role</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Role</li>
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
            <router-link class="btn btn-info btn-sm" :to="'/role/create'">
              Add Role <i class="fas fa-user-plus"></i>
            </router-link>
          </div>
        </div>
        <div class="card-body">
          <div class="container-fluid">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Search Criteria</h3>
              </div>
              <div class="card-body">
                <form role="form">
                  <div class="row">
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Name</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillSearchRole.name"
                          @keyup.enter="getlistRoles"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Url</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="fillSearchRole.slug"
                          @keyup.enter="getlistRoles"
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
                      @click.prevent="getlistRoles"
                      v-loading.fullscreen.lock="fullscreenLoading"
                    >
                      Search
                    </button>
                    <button
                      class="btn btn-flat btn-default btn-width"
                      @click.prevent="clearSearchCriteria"
                    >
                      Clear
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Inbox Results</h3>
              </div>
              <div class="card-body table-reponsive">
                <template v-if="listRolesPaginated.length">
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
                        <th>Url</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, key) in listRolesPaginated" :key="key">
                        <td v-text="item.name"></td>
                        <td v-text="item.slug"></td>
                        <td>
                          <button
                            class="btn btn-flat btn-primary btn-sm"
                            @click="openModalByOptions('role', 'view', item)"
                          >
                            <i class="fas fa-folder"></i> View
                          </button>
                          <router-link
                            class="btn btn-flat btn-info btn-sm"
                            :to="{
                              name: '/role/edit',
                              params: { id: item.id },
                            }"
                          >
                            <i class="fas fa-pencil-alt"></i> Edit
                          </router-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                      <li class="page-item" v-if="pageNumber > 0">
                        <a
                          href=""
                          class="page-link"
                          @click.prevent="previusPage"
                          >Prev</a
                        >
                      </li>
                      <li
                        :class="[
                          'page-item',
                          item == pageNumber ? 'active' : '',
                        ]"
                        v-for="(item, key) in pageList"
                        :key="key"
                      >
                        <a
                          href=""
                          class="page-link"
                          @click.prevent="selectPage(item)"
                        >
                          {{ item + 1 }}
                        </a>
                      </li>
                      <li class="page-item" v-if="pageNumber < pageCount - 1">
                        <a href="" class="page-link" @click.prevent="nextPage"
                          >Next</a
                        >
                      </li>
                    </ul>
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
            <template v-if="modalOption === 1">
              <div
                class="callout callout-danger"
                style="padding: 5px"
                v-for="(item, key) in messageError"
                :key="key"
                v-html="item"
              />
            </template>
            <template v-if="modalOption === 2">
              <div class="container-fluid">
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Role Information</h3>
                  </div>
                  <div class="card-body">
                    <form role="form">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="col-md-12 col-form-label">Name</label>
                          <div class="col-md-12">
                            <span
                              class="form-control"
                              v-text="fillViewRole.name"
                            />
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label class="col-md-12 col-form-label">Url</label>
                          <div class="col-md-12">
                            <span
                              class="form-control"
                              v-text="fillViewRole.slug"
                            />
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">List Permissions</h3>
                  </div>
                  <div class="card-body table-reponsive">
                    <template v-if="listRolesPaginated.length">
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
                              <th>Url</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="(item, key) in listPermissions"
                              :key="key"
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
                </div>
              </div>
            </template>
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
      modalShow: false,
      modalOption: 0,
      viewModal: {
        display: "block",
        background: "#00000006b",
      },
      hideModal: {
        display: "none",
      },
      error: 0,
      messageError: [],
      pageNumber: 0,
      itemsPerPage: 10,
      fillSearchRole: {
        name: "",
        slug: "",
      },
      fillViewRole: {
        idRole: "",
        name: "",
        slug: "",
      },
      listRoles: [],
      fullscreenLoading: false,
      listPermissions: [],
    };
  },
  computed: {
    pageCount() {
      let a, b;
      a = this.listRoles.length;
      b = this.itemsPerPage;
      return Math.ceil(a / b);
    },
    listRolesPaginated() {
      let start, end;
      start = this.pageNumber * this.itemsPerPage;
      end = start + this.itemsPerPage;
      return this.listRoles.slice(start, end);
    },
    pageList() {
      let count, pagesArray;
      count = 0;
      pagesArray = [];
      while (count < this.pageCount) {
        pagesArray.push(count);
        count++;
      }
      return pagesArray;
    },
  },
  methods: {
    openModal() {
      this.modalShow = !this.modalShow;
    },
    closedModal() {
      this.modalShow = !this.modalShow;
      this.cleanModalOptions();
    },
    cleanModalOptions() {
        this.fillViewRole.name = "";
        this.fillViewRole.slug = "";
        this.listPermissions = [];
        this.modalOption = 0;
    },
    nextPage() {
      this.pageNumber += 1;
    },
    previusPage() {
      this.pageNumber -= 1;
    },
    selectPage(page) {
      this.pageNumber = page;
    },
    initializePagination() {
      this.pageNumber = 0;
    },
    clearSearchCriteria() {
      this.fillSearchRole.name = "";
      this.fillSearchRole.slug = "";
    },
    clearInboxUsers() {
      this.listRoles = [];
    },
    getlistRoles() {
      this.fullscreenLoading = true;
      let url = `/admin/role/getlistRoles`;
      axios
        .get(url, {
          params: {
            name: this.fillSearchRole.name,
            slug: this.fillSearchRole.slug,
          },
        })
        .then((response) => {
          this.initializePagination();
          this.listRoles = response.data;
          this.fullscreenLoading = false;
        });
    },
    getListPermissionsByRole(id) {
      const url = "/admin/role/getListPermissionsByRole";
      axios
        .get(url, {
          params: {
            idRole: id,
          },
        })
        .then((response) => {
          this.listPermissions = response.data;
          this.modalShow = true;
          this.modalOption = 2;
        });
    },
    openModalByOptions(module, action, data) {
      switch (module) {
        case "role":
          switch (action) {
            case "view":
                // Set information:
                this.fillViewRole.name = data.name;
                this.fillViewRole.slug = data.slug;
                // Get permission by role:
                this.getListPermissionsByRole(data?.id);
              break;
            default:
              break;
          }
          break;
        default:
          break;
      }
    },
  },
  mounted() {
    this.getlistRoles();
  },
};
</script>
<style></style>
