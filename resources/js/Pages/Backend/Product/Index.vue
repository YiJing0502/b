<!-- vue -->
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
// optional的寫法
export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  props: {
    response: Object,
  },
  methods: {
    isPublic(num = 0) {
      if (![1, 2].includes(num)) return '';
      return num === 1 ? '公開' : '非公開';
    },
  },
};
</script>

<!-- 頁面 -->
<template>
  <Head title="Product" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product</h2>
        <!-- 內部Link 外網a -->
        <Link :href="route('product.create')">
          <button type="button" class="font-semibold text-xl text-gray-800 leading-tight border-black p-2 rounded-sm border-2">新增商品</button>
        </Link>
      </div>
    </template>
    <section id="product-show">
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <table class="w-full border-black border-2">
            <thead>
              <th>#</th>
              <th>建立時間</th>
              <th>產品名稱</th>
              <th>產品價格</th>
              <th>公開選擇</th>
              <th>描述</th>
            </thead>
            <tbody>
              <tr v-for="(item, index) in response.rt_data" :key="item.id">
                <!-- :key 新增資料生成確認 -->
                <td>{{ index + 1 }}</td>
                <td>{{ item.timeFormat }}</td>
                <td>{{ item.name }}</td>
                <td>${{ item.price }}</td>
                <td>{{ isPublic(item.public) }}</td>
                <td>{{ item.desc }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </AuthenticatedLayout>
</template>

<!-- style -->
<style lang="scss" scoped>
#product-show {
    table {
        @apply text-center;
        td {
            @apply text-gray-600 border-black border-2;
        }
    }
}
</style>
