<!-- vue -->
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

// optional的寫法
export default {
  components: {
    AuthenticatedLayout,
    Head,
  },
  data() {
    return {
      formData: {
        name: '',
        price: '',
        public: '',
        desc: '',
      },
    };
  },
  methods: {
    submitData() {
      // 驗證
      // [inertia] -method- to submit
      router.visit(route('product.store'), {
        method: 'post',
        data: this.formData,
        // 新增完，停留，資料留存
        preserveState: true,
        onSuccess: (page) => {
          console.log(page);
          console.log(page.props.flash.message.rt_code);
          if (page.props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '新增成功！',
              showDenyButton: true,
              confirmButtonText: '回列表',
              denyButtonText: '取消',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                router.get(route('product.list'));
              }
            });
          }
        },
      });
    },
  },
};
</script>

<!-- 頁面 -->
<template>
  <Head title="Product-Create" />

  <AuthenticatedLayout>
    <template #header>
      <div class="">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product/Create</h2>

      </div>
    </template>
    <section id="product-create" class="">
      <form @submit.prevent="submitData()" action="" class="product-form">
        {{ formData }}
        <label>
          商品名稱：
          <input v-model="formData.name" type="text" name="name" required>
        </label>
        <label>
          商品價格：
          <input v-model="formData.price" type="number" name="price" min="0" required>
        </label>
        <div class="flex gap-3">
          <label>
            商品公開：
            <input v-model="formData.public" type="radio" name="public" value="1" required>公開
          </label>
          <label>
            <input v-model="formData.public" type="radio" name="public" value="2">非公開
          </label>
        </div>
        <label>
          商品描述：
          <input v-model="formData.desc" type="text" name="desc" required>
        </label>
        <div class="flex gap-3 mx-auto mt-2">
          <!-- 內部Link 外網a -->
          <Link :href="route('product.list')">
            <button type="button" class="btn">取消新增</button>
          </Link>
          <button type="submit" class="btn">新增產品</button>
        </div>
      </form>
    </section>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">You're logged in!</div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<!-- style -->
<style lang="scss" scoped>
#product-create {
    @apply px-12 py-12;
    .product-form {
        @apply flex flex-col gap-5;
    }
    .btn {
        @apply font-semibold text-xl text-gray-800 leading-tight border-black p-2 rounded-sm border-2;
    }
}
</style>
