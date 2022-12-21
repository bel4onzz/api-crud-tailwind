<template>
  <div class="block p-6 rounded-lg shadow-lg bg-white">
    <h1 class="mb-4">Create Gig</h1>
    <div v-if="loading" class="flex justify-center items-center">
      <div
        class="
          spinner-border
          animate-spin
          inline-block
          w-8
          h-8
          border-4
          rounded-full
        "
        role="status"
      >
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div class="form-group mb-6">
      <input
        type="text"
        v-model="payload.name"
        class="
          form-control
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
        id="exampleInput7"
        placeholder="Gig Name"
      />
    </div>
    <div class="form-group mb-6">
      <input
        type="text"
        v-model="payload.description"
        class="
          form-control
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
        id="exampleInput8"
        placeholder="Gig Description"
      />
    </div>
    <div class="form-group mb-6">
      <select
        v-model="payload.company_id"
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
        placeholder="Companies"
      >
        <option selected>Select Company</option>
        <option
          v-for="company in companies"
          :key="company.id"
          :value="company.id"
        >
          {{ company.name }}
        </option>
      </select>
    </div>
    <div class="form-group mb-6">
      <Datepicker
        :format="'yyyy-MM-dd hh:mm'"
        v-model="payload.start"
        type="text"
        class="my-2 w-1/4"
        placeholder="Start date"
      />
    </div>
    <div class="form-group mb-6">
      <Datepicker
        :format="'yyyy-MM-dd hh:mm'"
        v-model="payload.end"
        type="text"
        class="my-2 w-1/4"
        placeholder="End date"
      />
    </div>
    <div class="form-group mb-6">
      <input
        type="text"
        v-model="payload.number_of_position"
        class="
          form-control
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
        id="exampleInput8"
        placeholder="Number of position"
      />
    </div>
    <div class="form-group mb-6">
      <input
        type="text"
        v-model="payload.pay_per_hour"
        class="
          form-control
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
        id="exampleInput8"
        placeholder="Pay per hour"
      />
    </div>
    <div class="form-group mb-6">
      <select
        v-model="payload.status"
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
        <option selected>Select Status</option>
        <option value="0">Draft</option>
        <option value="1">Posted</option>
      </select>
    </div>
    <button
      type="submit"
      @click="createGig"
      class="
        w-full
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
      Create
    </button>
  </div>
</template>

<script>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

export default {
  components: { Datepicker },
  created() {
    this.userCompanies();
  },
  data() {
    return {
      loading: false,
      companies: null,
      payload: {
        name: null,
        description: null,
        company_id: null,
        start: null,
        end: null,
        number_of_position: null,
        pay_per_hour: null,
        status: null,
      },
    };
  },
  inject: ["$apiroutes"],
  methods: {
    userCompanies() {
      this.$apiroutes
        .getusercompanies()
        .then((response) => {
          console.log("Companies RESPONSE");
          console.log(response);
          this.companies = response.data.data;
        })
        .catch((e) => {
          console.log("ERROR userCompanies");
          console.log(e);
        });
    },
    createGig() {
      this.loading = true;
      this.$apiroutes
        .creategig(this.payload)
        .then(() => {
          this.loading = false;
        })
        .catch(() => {
          this.loading = false;
        });
    },
  },
};
</script>
