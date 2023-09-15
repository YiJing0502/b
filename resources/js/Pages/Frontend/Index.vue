<script>
export default {
  props: {
    response: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
  data() {
    return {
      title: 'Hello World !',
    };
  },
  created() {
  },
};
</script>

<template>
  <section id="frontend-index">
    <h1 class="title">{{ title }}</h1>
    <div class="flex justify-center gap-5 mb-5">
      <Link :href="route('register')" class="btn-base">註冊</Link>
      <Link :href="route('dashboard')" class="btn-base">登入</Link>
    </div>
  </section>
</template>

<style lang="scss" scoped>
#frontend-index {
    @apply w-full h-full overflow-y-auto;

    .title {
        @apply text-[6.25rem] text-center;
    }

    .btn-base {
        @apply p-1.5 border-2 rounded-md border-green-500 cursor-pointer;
    }
}
</style>
