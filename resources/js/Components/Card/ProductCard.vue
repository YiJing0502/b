<script>
export default {
  // props:寫來自於父層傳給子層的資料
  // ex.提供給每張card要顯示的東西
  props: {
    // 因為是組件的狀況所以寫清楚
    // 簡寫：
    // productInfo: Object,
    // 小駝峰命名
    // 先申請要拿到什麼資料(可多個資料)
    productInfo: {
      type: Object,
      required: true,
      // default裡面放fun
      // 簡寫：
      // default: () => {{}},
      default: () => {
        return {};
      },
    },
  },
};
</script>

<template>
  <div class="my-product">
    <img :src="productInfo.image_path" class="aspect-[4/3] object-cover" alt="" width="50">
    <!-- 父層接受來自子層的資料 -->
    <p>商品名稱：{{ productInfo.name }}</p>
    <p>商品價格：{{ productInfo.price }}</p>
    <p>商品描述：{{ productInfo.desc }}</p>

  </div>
</template>

<style lang="scss" scoped>
.my-product {
    @apply p-6 lg:px-8 flex flex-wrap gap-4 mx-auto justify-center border-2 border-green-500 bg-slate-50 rounded-lg mx-10;
    .my-product-card {
        @apply w-1/4 p-2 border-2 border-green-500 bg-white rounded-md;
    }
}
</style>
