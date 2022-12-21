<template>
  <div>
    <div class="flex justify-start items-center ml-2 mb-4">
      <h1>Companies</h1>
      <button
        type="button"
        @click="createCompany"
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
        Create Company
      </button>
    </div>
    <div v-if="companies && companies.length">
      <ul class="bg-white rounded-lg border border-gray-200 text-gray-900">
        <li
          v-for="company in companies"
          :key="company.id"
          :class="editing[company.id] ? 'bg-sky-100' : ''"
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
            <span
              class="
                flex
                justify-between
                items-center
                mb-2
                border-b-2 border-gray-300
              "
            >
              <b v-if="!editing[company.id]">{{ company.name }}</b>
              <input
                v-else
                v-model="edit_data.name"
                type="text"
                class="
                  form-control
                  w-1/4
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
              <span
                ><b>Number of posted gigs: </b> {{ company.posted_gigs }}</span
              >
              <span
                ><b>Number of started gigs: </b>
                {{ company.started_gigs }}</span
              >
            </span>
            <p class="border-b border-gray-300">
              <b>Description: </b>
              <span v-if="!editing[company.id]">{{ company.description }}</span>
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
              <b>Address: </b>
              <span v-if="!editing[company.id]">{{ company.address }}</span>
              <input
                v-else
                v-model="edit_data.address"
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
                placeholder="Company Address"
              />
            </p>
          </div>
          <!-- ACTION ICONS -->
          <span class="flex justify-center items-center">
            <div class="flex space-x-2 justify-end">
              <i
                v-if="!editing[company.id]"
                @click="getCompanyData(company.id)"
                class="fa-solid fa-pen-to-square"
              ></i>
              <i
                v-if="!editing[company.id]"
                class="fa-solid fa-trash ml-4"
                @click="deleteCompanyData(company.id)"
              ></i>
              <i
                v-if="editing[company.id]"
                class="fa-solid fa-floppy-disk"
                @click="updateCompanyData(company.id)"
              ></i>
              <i
                v-if="editing[company.id]"
                class="fa-solid fa-xmark ml-4"
                @click="cancelCompanyData(company.id)"
              ></i>
            </div>
          </span>
          <!-- ACTION ICONS -->
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      companies: null,
      editing: [],
      edit_data: [],
    };
  },
  created() {
    this.userCompanies();
  },
  inject: ["$apiroutes"],
  methods: {
    userCompanies() {
      this.$apiroutes
        .getusercompanies()
        .then((response) => {
          this.companies = response.data.data;
        })
        .catch((e) => {
          console.log("ERROR userCompanies");
          console.log(e);
        });
    },
    createCompany() {
      console.log("CREATE COMPANY");
      this.$router.push("/companies/create");
    },
    getCompanyData(id) {
      this.editing = [];
      this.$apiroutes
        .getcompany(id)
        .then((response) => {
          this.edit_data = response.data.data[0];
          this.editing[id] = true;
        })
        .catch((e) => {
          console.log("ERROR getCompanyData");
          console.log(e);
        });
    },
    updateCompanyData(id) {
      this.$apiroutes.updatecompany(id, this.edit_data).then(() => {
        this.editing = [];
        this.userCompanies();
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
