<script>
// 引入我們製作的組件
import ProductCard from '@/Components/Card/ProductCard.vue';
// 方法二：交給引入此組件的頁面去處理
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

export default {
  //  components:使用到哪些組件
  components: {
    ProductCard,
  },
  //  props:寫來自後台傳過來的資料
  props: {
    // 方法二：交給引入此組件的頁面去處理
    router,
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
  methods: {
    getDataFormCard(obj) {
    //   console.log(obj);
      // 方法二：交給引入此組件的頁面去處理
      router.visit(route('product.addCart'), {
        method: 'post',
        data: {
          id: obj.id,
          qty: obj.qty,
        },
        preserveStatus: true,
        onSuccess: ({ props }) => {
        //   console.log(props);
          if (props.flash.message.rt_code === 1) {
            Swal.fire({
              title: '新增成功！',
            });
          }
        },
      });
    },
    logout() {
      router.visit(route('logout'), {
        method: 'post',
      });
    },
  },
};
</script>

<template>
  <section id="frontend-index">
    <h1 class="title">{{ title }}</h1>
    <!-- {{ $page.props.auth.user }} -->
    <div v-if="!$page.props.auth.user" class="flex justify-center gap-5 mb-5">
      <Link :href="route('register')" class="btn-base">註冊</Link>
      <Link :href="route('dashboard')" class="btn-base">登入</Link>
    </div>
    <div v-else class="flex justify-center gap-5 mb-5">
      <button type="button" class="btn-base" @click="logout()">登出</button>
      <Link :href="route('shopCart')" class="btn-base">我的購物車</Link>
    </div>
    <div class="product">
      <!-- :product-info="item" 父層開渠道傳資料 item放資料？ -->
      <!-- 頁面上的組件 -->
      <ProductCard v-for="item in response.rt_data ?? []" :key="item.id" :product-info="item" @add-cart="getDataFormCard">
        闆闆推薦
        <template #msg>
          <div>
            <h6>免運！</h6>
          </div>
        </template>
      </ProductCard>
      <!-- 單一用的時候 -->
      <!-- <div v-for="item in response.rt_data ?? []" :key="item.id" class="card">
        <img :src="item.image_path" class="w-full aspect-[4/3] object-cover" alt="">
        <p>商品名稱：{{ item.name }}</p>
        <p>商品價格：{{ item.price }}</p>
        <p>商品描述：{{ item.desc }}</p>
      </div> -->
      <img src="" alt="" width="">
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
