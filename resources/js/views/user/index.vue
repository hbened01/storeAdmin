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
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <router-link class="btn btn-info btn-sm" :to="'/user/create'">
              Add User <i class="fas fa-user-plus"></i>
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
                          v-model="FilterSearchUser.name"
                          @keyup.enter="getListUsers"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">User</label>
                      <div class="col-md-9">
                        <input
                          type="text"
                          class="form-control"
                          v-model="FilterSearchUser.user"
                          @keyup.enter="getListUsers"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">Email</label>
                      <div class="col-md-9">
                        <input
                          type="email"
                          class="form-control"
                          v-model="FilterSearchUser.email"
                          @keyup.enter="getListUsers"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="col-md-3 col-form-label">State</label>
                      <div class="col-md-9">
                        <template>
                          <el-select
                            v-model="FilterSearchUser.state"
                            placeholder="Select State"
                            clearable
                          >
                            <el-option
                              v-for="item in listState"
                              :key="item.value"
                              :label="item.label"
                              :value="item.value"
                            >
                            </el-option>
                          </el-select>
                        </template>
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
                      @click.prevent="getListUsers"
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
                <template v-if="listUsersPaginated.length">
                  <table
                    class="
                      table table-hover table-head-fixed
                      text-nowrap
                      projects
                    "
                  >
                    <thead>
                      <tr>
                        <th>Photography</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User</th>
                        <th>State</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, key) in listUsersPaginated" :key="key">
                        <td>
                          <span class="user-block">
                            <img
                              src="/img/avatar.png"
                              :alt="item.username"
                              class="profile-avatar-img img-fluid img-circle"
                            />
                          </span>
                        </td>
                        <td v-text="item.fullname"></td>
                        <td v-text="item.email"></td>
                        <td v-text="item.username"></td>
                        <td>
                          <template v-if="item.state == 'A'">
                            <span
                              class="badge badge-success"
                              v-text="item.state_alias"
                            ></span>
                          </template>
                          <template v-else>
                            <span
                              class="badge badge-danger"
                              v-text="item.state_alias"
                            ></span>
                          </template>
                        </td>
                        <td>
                          <router-link class="btn btn-primary btn-sm" :to="'/'">
                            <i class="fas fa-folder"></i> View
                          </router-link>
                          <router-link class="btn btn-info btn-sm" :to="'/'">
                            <i class="fas fa-pencil-alt"></i> Edit
                          </router-link>
                          <router-link class="btn btn-success btn-sm" :to="'/'">
                            <i class="fas fa-key"></i> Permit
                          </router-link>
                          <router-link class="btn btn-danger btn-sm" :to="'/'">
                            <i class="fas fa-trash"></i> Inactive
                          </router-link>
                          <router-link class="btn btn-success btn-sm" :to="'/'">
                            <i class="fas fa-check"></i> Active
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
                      No Data Information In Module Users
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
</template>
<script>
export default {
  name: "Users",
  props: {},
  mixins: [],
  data() {
    return {
      pageNumber: 0,
      itemsPerPage: 10,
      FilterSearchUser: {
        name: "",
        user: "",
        email: "",
        state: "",
      },
      listUsers: [],
      listState: [
        {
          value: "A",
          label: "ACTIVE",
        },
        {
          value: "I",
          label: "INACTIVE",
        },
      ],
      fullscreenLoading: false,
    };
  },
  computed: {
    pageCount() {
      let a, b;
      a = this.listUsers.length;
      b = this.itemsPerPage;
      return Math.ceil(a / b);
    },
    listUsersPaginated() {
      let start, end;
      start = this.pageNumber * this.itemsPerPage;
      end = start + this.itemsPerPage;
      return this.listUsers.slice(start, end);
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
      this.FilterSearchUser.name = "";
      this.FilterSearchUser.user = "";
      this.FilterSearchUser.email = "";
      this.FilterSearchUser.state = "";
    },
    clearInboxUsers() {
      this.listUsers = [];
    },
    getListUsers() {
      this.fullscreenLoading = true;
      let url = `/admin/user/getListUsers`;
      axios
        .get(url, {
          params: {
            name: this.FilterSearchUser.name,
            user: this.FilterSearchUser.user,
            email: this.FilterSearchUser.email,
            state: this.FilterSearchUser.state,
          },
        })
        .then((response) => {
          this.initializePagination();
          this.listUsers = response.data;
          this.fullscreenLoading = false;
        });
    },
  },
};
</script>
<style></style>
