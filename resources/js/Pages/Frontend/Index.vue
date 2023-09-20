<script>
import ProductCard from '@/Components/Card/ProductCard.vue';

export default {
  components: {
    ProductCard,
  },
  props: {
    response: {
      //  (必)
      type: Object,
      //  (選)可接可不接response
      required: false,
      //  (選)response預設值為空物件
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
    <div class="product">
      <ProductCard v-for="item in response.rt_data ?? []" :key="item.id" :product-info="item"></ProductCard>
      <!-- <div v-for="item in response.rt_data ?? []" :key="item.id" class="card">
        <p>商品名稱：{{ item.name }}</p>
        <p>商品價格：{{ item.price }}</p>
        <p>商品描述：{{ item.desc }}</p>
      </div> -->
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
    .product {
        @apply p-6 lg:px-8 flex flex-wrap gap-4 mx-auto justify-center border-2 border-green-500 bg-slate-50 rounded-lg mx-10;
    //     .card {
    //         @apply w-1/4 p-2 border-2 border-green-500 bg-white rounded-md;
    //     }
    }
}
</style>
