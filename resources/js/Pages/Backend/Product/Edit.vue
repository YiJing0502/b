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
  props: {
    // 從controller with接資料來頁面
    response: Object,
  },
  data() {
    return {
      formData: {
        id: this.response?.rt_data?.id ?? '',
        name: this.response?.rt_data?.name ?? '',
        price: this.response?.rt_data?.price ?? '',
        public: this.response?.rt_data?.public ?? '',
        desc: this.response?.rt_data?.desc ?? '',
        image: this.response.rt_data?.image_path ?? '',
        otherImage: this.response.rt_data?.productImage ?? '',
      },
    };
  },
  mounted() {
    console.log(this.response);
  },
  methods: {
    submitData(id) {
      // 如果沒有上傳新的主照片
      // 解構，扁平化，只拿要的資料
      const { response } = this;
      //   console.log();
      // 驗證
      // [inertia] -method- to submit
      Swal.fire({
        title: `確認更新「${response?.rt_data?.name ?? ''}」商品？`,
        showDenyButton: true,
        confirmButtonText: '更新！',
        denyButtonText: '取消',
      }).then((result) => {
        if (result.isConfirmed) {
          router.visit(route('product.update', { id: id }), {
            method: 'put',
            // 官網有說data是物件
            data: {
              formData: this.formData,
              id: id,
            },
            // 新增完，停留，資料留存
            preserveState: true,
            onSuccess: (page) => {
            //   console.log(page);
              //  console.log(page.props.flash.message.rt_code);
              if (page.props.flash.message.rt_code === 1) {
                Swal.fire({
                  title: '更新成功！',
                  showDenyButton: true,
                  confirmButtonText: '回列表',
                  denyButtonText: '取消',
                }).then((result) => {
                  if (result.isConfirmed) {
                    router.get(route('product.list'));
                  }
                });
              }
            },
          });

        }
      });
    },
    inputClass(item) {
      if (!item) return '';
      return 'border-[red]';
    },
    uploadeImage(event) {
      const file = event.target.files[0];
      if (!file) return '';
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        this.formData.image = reader.result;
      };
    },
    uploadeOtherImage(event) {
      // 確認id的功用？ 他是第幾個屬於哪一個資料，放到相對應的資料(圖片上)
      // console.log(event);
      const reader = new FileReader();
      reader.readAsDataURL(event.target.files[0]);
      reader.onload = () => {
        this.formData.otherImage.push({
          id: Math.max(0, ...this.formData.otherImage.map(item => item.id)) + 1,
          image_path: reader.result,
          size: event.target.files[0].size,
        });
        this.otherImageSize += event.target.files[0].size;
      };
    },
    removeImage(id) {
      //  找到被刪除的圖片
      const removedImage = this.formData.otherImage.find((item) => item.id === id);
      //   console.log(removedImage.size);
      if (removedImage) {
        // 減掉被刪除的圖片隻大小
        this.otherImageSize -= removedImage.size;
        // 把接到資料的id當成排除的id，過濾掉被刪除的圖片
        this.formData.otherImage = this.formData.otherImage.filter((item) => item.id !== id);
      }
    },
  },
};
</script>

<!-- 頁面 -->
<template>
  <Head title="Product-Edit" />
  <!-- {{ $page }} -->
  <AuthenticatedLayout>
    <template #header>
      <div class="">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product/Edit</h2>
      </div>
    </template>
    <section id="product-create" class="">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form @submit.prevent="submitData(formData.id)" action="" class="product-form">
          {{ formData }}
          <label>
            商品名稱：
            <input v-model="formData.name" type="text" name="name" :class="{ 'border-[red]': $page.props.errors['formData.name'] }" required>
            <!-- 驗證＿名稱提醒 -->
            <p class="error">{{ $page.props.errors['formData.name'] }}</p>
          </label>
          <label>
            商品價格：
            <input v-model="formData.price" type="number" name="price" min="0" :class="inputClass($page.props.errors['formData.price'])" required>
            <!-- 驗證＿價格提醒 -->
            <p class="error">{{ $page.props.errors['formData.price'] }}</p>
          </label>
          <div class="flex gap-3">
            <label>
              商品公開：
              <input v-model="formData.public" type="radio" name="public" value="1" required>公開
            </label>
            <label>
              <input v-model="formData.public" type="radio" name="public" value="2">非公開
            </label>
            <!-- 驗證＿公開提醒 -->
            <p class="error">{{ $page.props.errors['formData.public'] }}</p>
          </div>
          <label>
            商品描述：
            <input v-model="formData.desc" type="text" name="desc" :class="inputClass($page.props.errors['formData.desc'])" required>
            <!-- 驗證＿描述提醒 -->
            <p class="error">{{ $page.props.errors['formData.desc'] }}</p>
          </label>
          <label>
            商品照片：
            <input type="file" name="image" @change="(event) => uploadeImage(event)">
            <img :src="formData.image" alt="" class="my-image">
          </label>
          <!-- 其他商品照片區 -->
          <div class="">
            <span>其他商品照片：</span>
            {{ formData.otherImage }}
            <div class="flex flex-wrap gap-3">
              <div v-for="item in formData.otherImage" :key="item.id" class="">
                <!-- 負責新增照片 -->
                <img :src="item.image_path" alt="" class="my-image">
                <!-- x 刪除按鈕 -->
                <button type="button" @click="removeImage(item.id)">刪除</button>
              </div>
            </div>
            <!-- 負責上傳照片 -->
            <label class="my-image add-image">+
              <input type="file" name="image" class="hidden" @change="(event) => uploadeOtherImage(event)">
            </label>
          </div>
          <div class="flex gap-3 mx-auto mt-2">
            <!-- 內部Link 外網a -->
            <Link :href="route('product.list')">
              <button type="button" class="btn">取消編輯</button>
            </Link>
            <button type="submit" class="btn">儲存編輯</button>
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
        .error {
            @apply text-red-500;
        }
    }
    .btn {
        @apply font-semibold text-xl text-gray-800 leading-tight border-black p-2 rounded-sm border-2;
    }
        .my-image {
        @apply border-2 w-[200px] aspect-[4/3] object-cover mt-4 cursor-pointer;
    }
    .add-image {
        @apply flex justify-center items-center cursor-pointer text-[48px];
    }
}
</style>
