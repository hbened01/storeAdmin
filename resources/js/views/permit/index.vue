<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Permit</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Permit</li>
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
            <router-link class="btn btn-info btn-sm" :to="'/permit/create'">
              Add Permit <i class="fas fa-user-plus"></i>
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
                  <div class="col-md-6">
                    <label class="col-md-3 col-form-label">Name</label>
                    <div class="col-md-9">
                      <input
                        type="text"
                        class="form-control"
                        v-model="fillSearchPermit.name"
                        @keyup.enter="getListPermissions"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="col-md-3 col-form-label">Url</label>
                    <div class="col-md-9">
                      <input
                        type="text"
                        class="form-control"
                        v-model="fillSearchPermit.slug"
                        @keyup.enter="getListPermissions"
                      />
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-4 offset-4 style-inline-1">
                    <button
                      class="btn btn-flat btn-info btn-width"
                      @click.prevent="getListPermissions"
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
                <template v-if="listPermissionPaginated.length">
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
                      <tr
                        v-for="(item, key) in listPermissionPaginated"
                        :key="key"
                      >
                        <td v-text="item.name"></td>
                        <td v-text="item.slug"></td>
                        <td>
                          <router-link
                            class="btn btn-flat btn-info btn-sm"
                            :to="{
                              name: '/permit/edit',
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
  </div>
</template>
<script>
export default {
  name: "Permit",
  props: {},
  mixins: [],
  data() {
    return {
      pageNumber: 0,
      itemsPerPage: 10,
      fillSearchPermit: {
        name: "",
        slug: "",
      },
      fullscreenLoading: false,
      listPermissions: [],
    };
  },
  computed: {
    pageCount() {
      let a, b;
      a = this.listPermissions.length;
      b = this.itemsPerPage;
      return Math.ceil(a / b);
    },
    listPermissionPaginated() {
      let start, end;
      start = this.pageNumber * this.itemsPerPage;
      end = start + this.itemsPerPage;
      return this.listPermissions.slice(start, end);
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
      this.fillSearchPermit.name = "";
      this.fillSearchPermit.slug = "";
    },
    clearInboxUsers() {
      this.listPermissions = [];
    },
    getListPermissions() {
      this.fullscreenLoading = true;
      let url = `/admin/permit/getListPermissions`;
      axios
        .get(url, {
          params: {
            name: this.fillSearchPermit.name,
            slug: this.fillSearchPermit.slug,
          },
        })
        .then((response) => {
          this.initializePagination();
          this.listPermissions = response.data;
          this.fullscreenLoading = false;
        });
    },
  },
  mounted() {
    this.getListPermissions();
  },
};
</script>
<style></style>
