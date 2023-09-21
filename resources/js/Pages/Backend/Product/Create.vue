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
  data() {
    return {
    //  物件
      formData: {
        name: '',
        price: '',
        public: '',
        desc: '',
        image: '',
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
        //   console.log(page);
        //   console.log(page.props.flash.message.rt_code);
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
    uploadeImage(event) {
      // 1拿掉呼叫的小括號，這邊寫event
      // 2呼叫(event) => uploadeImage
    //   console.log(event.target.files[0]);
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        // console.log(reader.result);
        this.formData.image = reader.result;
        // 這一段為將字串塞進去formData.image
        // 使用箭頭函示，this可以指向到外部，就可以在data中找到formData.image
        // 使用一般fun，this指向 reader.onload
      };
    //   reader.onerror = (error) => {
    //     console.log('Error: ', error);
    //   };
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
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
          <label>
            商品照片：
            <!--
                使用者按的/實際觸動的，用fun轉base64-[file to base64 js]
                觸動uplode...fun，將資料塞進去，並交由js將字串存起來
            -->
            <input type="file" name="image" required @change="(event) => uploadeImage(event)">
            <div v-if="!formData.image" class="my-image add-image">+</div>
            <img v-else :src="formData.image" alt="" width="100" class="my-image">
          </label>
          <div class="flex gap-3 mx-auto mt-2">
            <!-- 內部Link 外網a -->
            <Link :href="route('product.list')">
              <button type="button" class="btn">取消新增</button>
            </Link>
            <button type="submit" class="btn">新增產品</button>
          </div>
        </form>
      </div>
    </section>
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
    .my-image {
        @apply border-2 w-[200px] aspect-[4/3] object-cover mt-4;
    }
    .add-image {
        @apply flex justify-center items-center cursor-pointer text-[48px];
    }
}
</style>
