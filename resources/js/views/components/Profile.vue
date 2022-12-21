<template>
  <div class="block p-6 rounded-lg shadow-lg bg-white">
    <h1 class="mb-4">Edit Profile</h1>
    <div v-if="!loading">
      <div class="form-group mb-6">
        <input
          type="text"
          v-model="user.name"
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
          placeholder="User Name"
        />
      </div>
      <div class="form-group mb-6">
        <input
          type="text"
          v-model="user.last_name"
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
          placeholder="Last Name"
        />
      </div>
      <div class="form-group mb-6">
        <input
          type="text"
          v-model="user.email"
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
          placeholder="Email"
        />
      </div>
      <div class="form-group mb-6">
        <p
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
          placeholder="Token"
        >
          {{ token }}
        </p>
      </div>
      <button
        type="submit"
        @click="updateUser"
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
        Update account
      </button>
    </div>
    <loading-page v-else class="absolute inset-0"></loading-page>
  </div>
</template>

<script>
import loadingPage from "./LoadingScreen.vue";
export default {
  components: { loadingPage },
  created() {
    this.userData();
  },
  data() {
    return {
      loading: false,
      user: {
        id: "",
        name: "",
        last_name: "",
        email: "",
      },
      token: null,
    };
  },
  inject: ["$apiroutes"],
  methods: {
    userData() {
      this.loading = true;
      this.$apiroutes
        .userinfo()
        .then((response) => {
          this.user = response.data.data;
          this.token = response.data.token.token;
          this.loading = false;
        })
        .catch((e) => {
          this.loading = false;
          console.log("ERROR userCompanies");
          console.log(e);
        });
    },
    updateUser() {
      this.loading = true;
      this.$apiroutes
        .updateuserinfo(this.user.id, this.user)
        .then((response) => {
          this.$store.dispatch("setUser", response.data);
          this.user = response.data.data;
          this.token = response.data.token;
          this.loading = false;
        })
        .catch((e) => {
          this.loading = false;
          console.log("ERROR UPDATE userCompanies");
          console.log(e);
        });
    },
  },
};
</script>
