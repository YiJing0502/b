<script>
export default {
  props: {
    // 由父層提供給子層資料，可多個
    productInfo: {
      type: Object,
      required: true,
      default: () => {
        return {};
      },
    },
  },
};
</script>

<template>
  <section class="my-product">

    <p>商品名稱：{{ productInfo.name }}</p>
    <p>商品價格：{{ productInfo.price }}</p>
    <p>商品描述：{{ productInfo.desc }}</p>

  </section>
</template>

<style lang="scss" scoped>
.my-product {
    @apply p-6 lg:px-8 flex flex-wrap gap-4 mx-auto justify-center border-2 border-green-500 bg-slate-50 rounded-lg mx-10;
    .my-product-card {
        @apply w-1/4 p-2 border-2 border-green-500 bg-white rounded-md;
    }
}
</style>
