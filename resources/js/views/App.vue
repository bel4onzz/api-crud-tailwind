<template>
  <nav
    class="
      relative
      w-full
      flex flex-wrap
      items-center
      justify-between
      py-2
      bg-gray-100
      text-gray-500
      hover:text-gray-700
      focus:text-gray-700
      shadow-lg
      navbar navbar-expand navbar-light
      my-4
    "
  >
    <div class="w-full grid grid-cols-4 place-content-between px-6">
      <!-- Left links -->
      <div
        class="collapse navbar-collapse items-center col-span-3"
        id="navbarSupportedContent"
      >
        <!-- Left links -->
        <router-link to="/"
          ><i class="fa-solid fa-house fa-xl text-gray-900 hover:text-violet-600"></i
        ></router-link>
        <ul
          v-if="$store.getters.getToken != 'null'"
          class="ml-2 navbar-nav flex flex-col pl-0 list-style-none mr-auto"
        >
          <li
            class="
              nav-item
              nav-link
              hover:shadow-lg hover:text-gray-700
              shadow-cyan-500/50
              focus:border-transparent focus:text-gray-700
              border-bottom-active-link
            "
          >
            <router-link to="/companies" class="p-2">Companies</router-link>
          </li>
          <li
            class="
              nav-item
              nav-link
              hover:shadow-lg hover:text-gray-700
              shadow-cyan-500/50
              focus:border-transparent focus:text-gray-700
              border-bottom-active-link
            "
          >
            <router-link to="/gigs" class="p-2">Gigs</router-link>
          </li>
        </ul>
        <!-- Left links -->
      </div>
      <!-- Left links -->

      <!-- Right elements -->
      <div
        class="collapse navbar-collapse items-center justify-end"
        id="navbarSupportedContent"
      >
        <div class="flex justify-center">
          <div>
            <div class="dropstart relative">
              <router-link
                v-if="$store.getters.getToken == 'null'"
                to="/login"
                class="mr-2"
                >Log In</router-link
              >
              <router-link
                v-if="$store.getters.getToken == 'null'"
                to="/register"
                >Register</router-link
              >
              <div>
                <a
                  v-if="$store.getters.getToken !== 'null'"
                  class="dropdown-toggle flex items-center hidden-arrow"
                  id="dropdownMenuButton2"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i>
                    <!-- {{ $store.getters.getUser }} -->
                    <span v-if="$store.getters.getUser">{{
                      $store.getters.getUser.name
                    }}</span>
                    <i class="fa-solid fa-user fa-xl"></i>
                  </i>
                </a>
                <ul
                  v-if="$store.getters.getToken !== 'null'"
                  class="
                    dropdown-menu
                    min-w-max
                    absolute
                    hidden
                    bg-white
                    text-base
                    z-50
                    float-left
                    py-2
                    list-none
                    text-left
                    rounded-lg
                    shadow-lg
                    mt-1
                    hidden
                    m-0
                    bg-clip-padding
                    border-none
                  "
                  aria-labelledby="dropdownMenuButton1s"
                >
                  <li>
                    <router-link
                      to="/profile"
                      class="
                        dropdown-item
                        text-sm
                        py-2
                        px-4
                        font-normal
                        block
                        w-full
                        whitespace-nowrap
                        bg-transparent
                        text-gray-700
                        hover:bg-gray-100
                      "
                      >Profile</router-link
                    >
                  </li>
                  <li>
                    <button
                      @click.prevent="logout"
                      class="
                        dropdown-item
                        text-sm
                        py-2
                        px-4
                        font-normal
                        block
                        w-full
                        whitespace-nowrap
                        bg-transparent
                        text-gray-700
                        hover:bg-gray-100
                      "
                    >
                      Log Out
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Right elements -->
    </div>
  </nav>

  <router-view class="mt-2 mx-4"> </router-view>
</template>

<script>
export default {
  data() {
    return {};
  },
  inject: ["$apiroutes"],
  created() {
    if (this.$store.getters.getToken) {
      axios.interceptors.request.use(
        (config) => {
          config.headers[
            "Authorization"
          ] = `Bearer ${this.$store.getters.getToken}`;
          return config;
        },
        (error) => {
          return Promise.reject(error);
        }
      );
    }
  },
  methods: {
    logout() {
      this.$apiroutes
        .logoutuser()
        .then((response) => {
          console.log("LOGOUT RESPONSE");
          console.log(response);
        })
        .catch((e) => {
          console.log("ERROR LOGOUT USER");
          console.log(e);
        });
      let payload = {
        data: "null",
        token: "null",
      };
      this.$store.dispatch("setUser", payload);
      this.$router.push("/");
    },
  },
};
</script>

<style>
  .border-bottom-active-link>a.active{
    padding:10px;
    border-bottom: 2px solid blue !important;
    color: black;
  }
</style>
