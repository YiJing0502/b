<!-- vue -->
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
// optional的寫法
export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  props: {
    // 有傳東西就要寫
    response: Object,
  },
  methods: {
    // 顯示公開與非公開
    isPublic(num = 0) {
      if (![1, 2].includes(num)) return '';
      return num === 1 ? '公開' : '非公開';
    },
    deleteProduct(id) {
      console.log(id);
      Swal.fire({
        title: '確定要刪除嗎？',
        showDenyButton: true,
        confirmButtonText: '刪除！',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
        // 去刪除，使用inertia的方法
          router.visit(route('product.delete'), {
            method: 'DELETE',
            //  data是form表單裡面的body資料(input/name/value)，將id包在裡面，偷偷地送、驗證、刪除，其他人看不到這個id(不把id寫在路由，而是包在form表單裡面)
            data: { id: id },
            // { key: value}
            // key: 自定義 value是fun傳參數給他
          });
        }
      });
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
              <th>操作</th>
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
                <td>
                  <Link :href="route('product.edit', { id: item.id })">
                    <button type="button" class="mr-4">編輯</button>
                  </Link>
                  <button type="button" @click="deleteProduct(item.id)">刪除</button>
                </td>
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
