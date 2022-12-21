<template>
  <div class="block p-6 rounded-lg shadow-lg bg-white">
    <h1 class="mb-4">Create Company</h1>
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
        placeholder="Company Name"
      />
    </div>
    <div class="form-group mb-6">
      <input
        type="text"
        v-model="payload.address"
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
        placeholder="Company Address"
      />
    </div>
    <div class="form-group mb-6">
      <textarea
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
        id="exampleFormControlTextarea13"
        rows="3"
        placeholder="Company Description"
      ></textarea>
    </div>
    <button
      type="submit"
      @click="createCompany"
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
export default {
  data() {
    return {
      loading: false,
      payload: {
        name: null,
        description: null,
        address: null,
      },
    };
  },
  inject: ["$apiroutes"],
  methods: {
    createCompany() {
      this.loading = true;
      this.$apiroutes.createcompany(this.payload).then(() => {
        this.loading = false;
      }).catch(() => {
        this.loading = false;
      });
    },
  },
};
</script>
