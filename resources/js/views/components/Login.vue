<template>
  <div>
    <main v-if="!loading">
      <section class="absolute w-full h-full">
        <div class="absolute top-0 w-full h-full"></div>
        <div class="container mx-auto px-4 h-full">
          <div class="flex content-center items-center justify-center h-full">
            <div class="w-full lg:w-4/12 px-4">
              <div
                class="
                  relative
                  flex flex-col
                  min-w-0
                  break-words
                  w-full
                  mb-6
                  shadow-lg
                  rounded-lg
                  border-0
                "
              >
                <div class="flex-auto px-4 lg:px-10 py-10">
                  <form @keyup.enter="loginUser">
                    <div class="relative w-full mb-3">
                      <label
                        class="
                          block
                          uppercase
                          text-gray-700 text-xs
                          font-bold
                          mb-2
                        "
                        for="grid-password"
                        >Email</label
                      ><input
                        ref="email_address"
                        type="email"
                        v-model="form.email"
                        id="email-address"
                        name="email"
                        autocomplete="email"
                        required=""
                        class="
                          border-0
                          px-3
                          py-3
                          placeholder-gray-400
                          text-gray-700
                          bg-white
                          rounded
                          text-sm
                          shadow
                          focus:outline-none focus:ring
                          w-full
                        "
                        placeholder="Email"
                        style="transition: all 0.15s ease 0s"
                      />
                    </div>
                    <div class="relative w-full mb-3">
                      <label
                        class="
                          block
                          uppercase
                          text-gray-700 text-xs
                          font-bold
                          mb-2
                        "
                        for="grid-password"
                        >Password</label
                      ><input
                        type="password"
                        v-model="form.password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required=""
                        class="
                          border-0
                          px-3
                          py-3
                          placeholder-gray-400
                          text-gray-700
                          bg-white
                          rounded
                          text-sm
                          shadow
                          focus:outline-none focus:ring
                          w-full
                        "
                        placeholder="Password"
                        style="transition: all 0.15s ease 0s"
                      />
                    </div>

                    <div class="text-center mt-6">
                      <button
                        @click.prevent="loginUser"
                        class="
                          bg-gray-900
                          text-white
                          active:bg-gray-700
                          text-sm
                          font-bold
                          uppercase
                          px-6
                          py-3
                          rounded
                          shadow
                          hover:shadow-lg hover:bg-violet-600
                          outline-none
                          focus:outline-none
                          mr-1
                          mb-1
                          w-full
                        "
                        type="button"
                        style="transition: all 0.15s ease 0s"
                      >
                        Sign In
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="relative flex flex-col flex-wrap mt-6">
                <div class="w-full text-right">
                  <router-link
                    v-if="$store.getters.getToken == 'null'"
                    to="/register"
                    >Create new account</router-link
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <loading-page v-else class="absolute inset-0"></loading-page>
  </div>
</template>
<script>
import loadingPage from "./LoadingScreen.vue";
export default {
  name: "login-page",

  components: { loadingPage },

  data() {
    return {
      loading: false,
      form: {
        email: null,
        password: null,
      },
    };
  },
  inject: ["$apiroutes"],
  mounted() {
    this.$refs["email_address"].focus();
  },
  methods: {
    loginUser() {
      this.loading = true;
      this.$apiroutes
        .loginuser(this.form)
        .then((response) => {
          this.loading = false;
          this.$store.dispatch("setUser", response.data);
          this.$router.push("/");
        })
        .catch((e) => {
          this.loading = false;
          console.log("ERROR LOGIN USER");
          console.log(e);
        });
    },
  },
};
</script>
