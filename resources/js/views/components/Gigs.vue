<template>
  <div>
    <div class="flex justify-start items-center ml-2 mb-4">
      <h1>GIGS</h1>
      <button
        type="button"
        @click="createGig"
        data-mdb-ripple="true"
        data-mdb-ripple-color="light"
        class="
          inline-block
          ml-4
          px-6
          py-2.5
          bg-blue-600
          text-white
          font-medium
          text-xs
          leading-tight
          uppercase
          rounded
          shadow-md
          hover:bg-blue-700 hover:shadow-lg
          focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
          active:bg-blue-800 active:shadow-lg
          transition
          duration-150
          ease-in-out
        "
      >
        Create Gig
      </button>
    </div>
    <!--FILTERS-->
    <div class="flex justify-start items-center ml-2 mb-4">
      <h1>CompanyFilter:</h1>
      <div class="w-full ml-4 mr-2">
        <p><b>Selected: </b> {{ company_filter.name }}</p>
        <select
          v-model="filter_params.companies"
          @change="handleSearch"
          class="
            form-select
            appearance-none
            block
            w-full
            px-3
            py-1.5
            text-base
            font-normal
            text-gray-700
            bg-white bg-clip-padding bg-no-repeat
            border border-solid border-gray-300
            rounded
            transition
            ease-in-out
            m-0
            focus:text-gray-700
            focus:bg-white
            focus:border-blue-600
            focus:outline-none
          "
          aria-label="Default select example"
        >
          <option @click.prevent="resetFilter">All</option>
          <option
            v-for="(company, key) in filter_params.companies"
            :key="key"
            :value="key"
          >
            {{ company }}
          </option>
        </select>
      </div>

      <h1>Progress:</h1>
      <div class="w-full ml-4 mr-2">
        <p><b>Selected: </b> {{ progress_filter.name }}</p>
        <select
          v-model="filter_params.progress"
          @change="handleSearch"
          class="
            form-select
            appearance-none
            block
            w-full
            px-3
            py-1.5
            text-base
            font-normal
            text-gray-700
            bg-white bg-clip-padding bg-no-repeat
            border border-solid border-gray-300
            rounded
            transition
            ease-in-out
            m-0
            focus:text-gray-700
            focus:bg-white
            focus:border-blue-600
            focus:outline-none
          "
          aria-label="Default select example"
        >
          <option @click.prevent="resetFilter">All</option>
          <option
            v-for="progress in filter_params.progress"
            :key="progress"
            :value="progress"
          >
            {{ progress }}
          </option>
        </select>
      </div>

      <h1>Status:</h1>
      <div class="w-full ml-4 mr-2">
        <p><b>Selected: </b> {{ status_filter.name }}</p>
        <select
          v-model="filter_params.status"
          @change="handleSearch"
          class="
            form-select
            appearance-none
            block
            w-full
            px-3
            py-1.5
            text-base
            font-normal
            text-gray-700
            bg-white bg-clip-padding bg-no-repeat
            border border-solid border-gray-300
            rounded
            transition
            ease-in-out
            m-0
            focus:text-gray-700
            focus:bg-white
            focus:border-blue-600
            focus:outline-none
          "
          aria-label="Default select example"
        >
          <option
            v-for="(status, key) in filter_params.status"
            :key="key"
            :value="key"
          >
            {{ status }}
          </option>
        </select>
      </div>

      <h1>Search</h1>
      <div class="input-group relative flex flex-wrap items-stretch w-full">
        <input
          v-model="search_query"
          type="search"
          class="
            form-control
            relative
            flex-auto
            min-w-0
            block
            w-full
            px-3
            py-1.5
            text-base
            font-normal
            text-gray-700
            bg-white bg-clip-padding
            border border-solid border-gray-300
            rounded
            transition
            ease-in-out
            m-0
            focus:text-gray-700
            focus:bg-white
            focus:border-blue-600
            focus:outline-none
          "
          placeholder="Search"
          aria-label="Search"
          aria-describedby="button-addon2"
        />
        <button
          @click="handleSearch"
          class="
            btn
            inline-block
            px-6
            py-2.5
            bg-blue-600
            text-white
            font-medium
            text-xs
            leading-tight
            uppercase
            rounded
            shadow-md
            hover:bg-blue-700 hover:shadow-lg
            focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
            active:bg-blue-800 active:shadow-lg
            transition
            duration-150
            ease-in-out
            flex
            items-center
          "
          type="button"
          id="button-addon2"
        >
          <svg
            aria-hidden="true"
            focusable="false"
            data-prefix="fas"
            data-icon="search"
            class="w-4"
            role="img"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
          >
            <path
              fill="currentColor"
              d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"
            ></path>
          </svg>
        </button>
      </div>
    </div>
    <!--FILTERS-->

    <!--GIGS LIST-->
    <div v-if="gigs">
      <ul class="bg-white rounded-lg border border-gray-200 text-gray-900">
        <li
          v-for="gig in gigs"
          :key="gig.id"
          :class="editing[gig.id] ? 'bg-sky-100' : ''"
          class="
            inline-grid
            grid-cols-12
            px-6
            py-2
            border-b border-b-2 border-gray-500
            w-full
            rounded-t-lg
          "
        >
          <div class="col-span-11 mb-2">
            <div
              class="
                flex
                justify-between
                items-center
                mb-2
                pb-3
                pt-2
                border-b-2 border-gray-300
              "
            >
              <!--GIGS NAME-->
              <div class="w-full">
                <b v-if="!editing[gig.id]">{{ gig.name }}</b>
                <input
                  v-else
                  v-model="edit_data.name"
                  type="text"
                  class="
                    form-control
                    w-4/5
                    my-2
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700
                    focus:bg-white
                    focus:border-blue-600
                    focus:outline-none
                  "
                  placeholder="Company Name"
                />
              </div>
              <div class="w-full">
                <b>Company: </b>
                <span v-if="!editing[gig.id]">
                  {{ gig.company.name }}
                </span>
                <select
                  v-else
                  v-model="edit_data.company.id"
                  class="
                    form-select
                    appearance-none
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding bg-no-repeat
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700
                    focus:bg-white
                    focus:border-blue-600
                    focus:outline-none
                  "
                  aria-label="Default select example"
                >
                  <option
                    v-for="(company, key) in filter_params.companies"
                    :key="key"
                    :value="key"
                  >
                    {{ company }}
                  </option>
                </select>
              </div>
              <!--GIGS NAME-->

              <!--GIGS PROGRESS-->
              <div class="w-full">
                <b>Progress: </b> <span> {{ gig.progress }}</span>
              </div>
              <!--GIGS PROGRESS-->

              <!--GIGS STATUS-->
              <div class="w-full flex justify-between items-center">
                <b>Status: </b>
                <span v-if="!editing[gig.id]">{{
                  gig.status ? "Posted" : "Draft"
                }}</span>
                <select
                  v-else
                  class="
                    form-select
                    appearance-none
                    block
                    w-4/5
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding bg-no-repeat
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    m-0
                    focus:text-gray-700
                    focus:bg-white
                    focus:border-blue-600
                    focus:outline-none
                  "
                  aria-label="Default select example"
                >
                  <option value="0">Draft</option>
                  <option value="1">Posted</option>
                </select>
              </div>
              <!--GIGS STATUS-->
            </div>
            <p class="border-b border-gray-300">
              <b>Description: </b>
              <span v-if="!editing[gig.id]">{{ gig.description }}</span>
              <textarea
                v-else
                v-model="edit_data.description"
                class="
                  form-control
                  my-2
                  block
                  px-3
                  py-1.5
                  text-base
                  font-normal
                  text-gray-700
                  bg-white bg-clip-padding
                  border border-solid border-gray-300
                  rounded
                  transition
                  ease-in-out
                  focus:text-gray-700
                  focus:bg-white
                  focus:border-blue-600
                  focus:outline-none
                "
                id="exampleFormControlTextarea1"
                rows="3"
                placeholder="Your message"
              ></textarea>
            </p>
            <p class="border-b border-gray-300">
              <b>Start date: </b>
              <span v-if="!editing[gig.id]">{{ gig.start }}</span>
              <Datepicker
                v-else
                :format="'yyyy-MM-dd hh:mm'"
                v-model="edit_data.start"
                type="text"
                class="my-2 w-1/4"
                placeholder="Start date"
              />
            </p>
            <p class="border-b border-gray-300">
              <b>End date: </b>
              <span v-if="!editing[gig.id]">{{ gig.end }}</span>
              <Datepicker
                v-else
                v-model="edit_data.end"
                type="text"
                class="my-2 w-1/4"
                placeholder="End date"
              />
            </p>
            <p class="border-b border-gray-300">
              <b>Number of positions: </b>
              <span v-if="!editing[gig.id]">{{ gig.number_of_position }}</span>
              <input
                v-else
                v-model="edit_data.number_of_position"
                type="text"
                class="
                  form-control
                  my-2
                  w-1/4
                  px-3
                  py-1.5
                  text-base
                  font-normal
                  text-gray-700
                  bg-white bg-clip-padding
                  border border-solid border-gray-300
                  rounded
                  transition
                  ease-in-out
                  m-0
                  focus:text-gray-700
                  focus:bg-white
                  focus:border-blue-600
                  focus:outline-none
                "
                placeholder="Number of positions"
              />
            </p>
            <p class="border-b border-gray-300">
              <b>Pay per hour: </b>
              <span v-if="!editing[gig.id]">{{ gig.pay_per_hour }}</span>
              <input
                v-else
                v-model="edit_data.pay_per_hour"
                type="text"
                class="
                  form-control
                  my-2
                  w-1/4
                  px-3
                  py-1.5
                  text-base
                  font-normal
                  text-gray-700
                  bg-white bg-clip-padding
                  border border-solid border-gray-300
                  rounded
                  transition
                  ease-in-out
                  m-0
                  focus:text-gray-700
                  focus:bg-white
                  focus:border-blue-600
                  focus:outline-none
                "
                placeholder="Pay per hour"
              />
            </p>
          </div>
          <!-- ACTION ICONS -->
          <span class="flex justify-center items-center">
            <div class="flex space-x-2 justify-end">
              <i
                v-if="!editing[gig.id]"
                @click="getGigData(gig.id)"
                class="fa-solid fa-pen-to-square"
              ></i>
              <i
                v-if="!editing[gig.id]"
                class="fa-solid fa-trash ml-4"
                @click="deleteCompanyData(gig.id)"
              ></i>
              <i
                v-if="editing[gig.id]"
                class="fa-solid fa-floppy-disk"
                @click="updateGigData(gig.id)"
              ></i>
              <i
                v-if="editing[gig.id]"
                class="fa-solid fa-xmark ml-4"
                @click="cancelCompanyData(gig.id)"
              ></i>
            </div>
          </span>
          <!-- ACTION ICONS -->
        </li>
      </ul>
      <pagination
        v-if="gigs"
        class="mt-4"
        :totalPages="totalPages"
        :perPage="perPage"
        :currentPage="currentPage"
        @pagechanged="onPageChange"
      />
    </div>
    <!--GIGS LIST-->
  </div>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import Pagination from "./Pagination.vue";

export default {
  components: { Datepicker, Pagination },
  data() {
    return {
      totalRecords: 0,
      totalPages: 10,
      perPage: 5,
      currentPage: 1,
      gigs: null,
      editing: [],
      edit_data: [],
      search_query: "",
      filter_params: {
        companies: null,
        progres: null,
        status: null,
      },
      company_filter: "",
      progress_filter: "",
      status_filter: "",
    };
  },
  created() {
    this.companyGigs();
  },
  inject: ["$apiroutes"],
  methods: {
    onPageChange(page) {
      this.currentPage = page;
      this.handleSearch();
    },
    handleSearch() {
      if (
        typeof this.filter_params.companies === "object" &&
        this.company_filter
      ) {
        this.filter_params.companies = this.company_filter.id;
      }
      if (
        typeof this.filter_params.progress === "object" &&
        this.progress_filter
      ) {
        this.filter_params.progress = this.progress_filter.name;
      }
      if (typeof this.filter_params.status === "object" && this.status_filter) {
        this.filter_params.status = this.status_filter.id;
      }
      this.$apiroutes
        .getcompanygigs({
          params: {
            page: this.currentPage,
            size: this.perPage,
            search_query: this.search_query,
            filter_params: this.filter_params,
          },
        })
        .then((response) => {
          this.gigs = response.data.data;
          this.filter_params = response.data.filters;
          this.company_filter = response.data.company_selected;
          this.progress_filter = response.data.progress_selected;
          this.status_filter = response.data.status_selected;
          this.totalRecords = response.data.total;
          this.totalPages = Math.floor(response.data.total / this.perPage) + 1;
        });
    },

    resetFilter() {
      this.filter_params = {
        companies: null,
        progres: null,
        status: null,
      };
    },

    companyGigs() {
      this.$apiroutes
        .getcompanygigs()
        .then((response) => {
          this.gigs = response.data.data;
          this.filter_params = response.data.filters;
          this.totalPages = Math.ceil(response.data.total / this.perPage);
        })
        .catch((e) => {
          console.log("ERROR userCompanies");
          console.log(e);
        });
    },

    createGig() {
      this.$router.push("/gigs/create");
    },

    getGigData(id) {
      this.editing = [];
      this.$apiroutes
        .getgig(id)
        .then((response) => {
          console.log("GIGS EDIT RESPONSE");
          console.log(response);
          this.edit_data = response.data.data[0];
          this.editing[id] = true;
        })
        .catch((e) => {
          console.log("ERROR getGigData");
          console.log(e);
        });
    },

    updateGigData(id) {
      this.$apiroutes.updategig(id, this.edit_data).then(() => {
        this.editing = [];
        this.companyGigs();
      });
    },

    deleteCompanyData(id) {
      this.$apiroutes.destroycompany(id).then(() => {
        this.editing = [];
        this.userCompanies();
      });
    },

    cancelCompanyData(id) {
      this.editing.splice(id, 1);
      this.edit_data = [];
    },
  },
};
</script>
