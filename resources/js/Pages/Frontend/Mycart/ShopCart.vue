<script>
export default {
  components: {
  },
  props: {
    response: Object,
  },
  data() {
    return {
      title: '我的購物車',
    };
  },
};
</script>

<!-- 頁面 -->
<template>
  <Head title="Product" />
  <section id="frontend-index">
    <h1 class="title">{{ title }}</h1>
    <div class="flex justify-center gap-5 mb-5">
      <Link :href="route('product')" class="btn-base">回到商品頁</Link>
    </div>
    <!-- {{ response }} -->
    <table class="w-full border-black border-2">
      <thead>
        <th>#</th>
        <th>商品圖片</th>
        <th>產品名稱</th>
        <th>產品價格</th>
        <th>描述</th>
        <th>操作</th>
      </thead>
      <tbody>
        <tr v-for="item in response.rt_data" :key="item.id">
          <!-- :key 新增資料生成確認 -->
          <td>{{ item.id }}</td>
          <td><img :src="item.product.image_path" alt="" width="50"></td>
          <td>{{ item.product.name }}</td>
          <td>{{ item.product.price }}</td>
          <td>{{ item.product.desc }}</td>
          <td>
            <Link>
              <button type="button" class="mr-4">編輯</button>
            </Link>
            <button type="button">刪除</button>
          </td>
        </tr>
      </tbody>
    </table>
  </section>

</template>

<!-- style -->
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
    }
    table {
        @apply text-center;
        td {
            @apply text-gray-600 border-black border-2 text-center;
        }
    }
}
</style>
