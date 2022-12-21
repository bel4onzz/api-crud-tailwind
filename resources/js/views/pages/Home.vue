<template>
  <!-- This example requires Tailwind CSS v3.0+ -->
  <div class="isolate mx-2 shadow-lg">
    <main>
      <div class="relative px-6 lg:px-8">
        <div class="mx-auto max-w-3xl pt-20 pb-32 sm:pt-48 sm:pb-40">
          <div>
            <div>
                <h3>Token ::: {{$store.getters.getToken}}</h3>
                <h3>User ::: {{$store.getters.getUser}}</h3>
              <h1
                class="
                  text-4xl
                  font-bold
                  tracking-tight
                  sm:text-center sm:text-6xl
                "
              >
                Home Page
              </h1>
              <p class="mt-6 text-lg leading-8 text-gray-600 sm:text-center">
                Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui
                lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat
                fugiat aliqua.
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
};
</script>
