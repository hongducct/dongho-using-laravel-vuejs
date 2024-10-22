<template>
  <TheHeader />
  <div class="bg-white pb-16">
    <div class="pt-6">
      <div class="breadcrumb-section rounded-full" style="background-color: #f5f5fa; padding: 20px 15px">
      <div class="container">
        <div class="row items-center">
          <div class="">
            <a-breadcrumb separator=">">
              <a-breadcrumb-item @click="navigateTo('/')"  class="flex items-center">
                <div class="flex items-center">
                  <HomeOutlined />
                  <span style="padding-left: 3px;">TRANG CHỦ</span>
                </div>
              </a-breadcrumb-item>
              <a-breadcrumb-item>{{ product.name }}</a-breadcrumb-item>
            </a-breadcrumb>
          </div>
        </div>
      </div>
    </div>

      <!-- Image gallery -->
      <div
        class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8"
      >
        <div
          class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block"
        >
          <img
            v-if="product.images && product.images.length > 0"
            :src="product.images[0]"
            alt="Hình ảnh sản phẩm"
            class="h-full w-full object-cover object-center"
          />
        </div>
        <div class="hidden lg:grid lg:grid-cols-1 lg:gap-y-8">
          <div
            v-if="Array.isArray(product.images) && product.images.length > 2"
            v-for="(image, index) in product.images.slice(1, 3)"
            :key="index"
            class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg"
          >
            <img
              :src="image"
              alt="Hình ảnh sản phẩm"
              class="h-96 w-full object-cover object-center"
            />
          </div>
        </div>
        <div
          class="aspect-h-5 aspect-w-4 lg:aspect-h-4 lg:aspect-w-3 sm:overflow-hidden sm:rounded-lg"
        >
          <img
            v-if="product.images && product.images.length > 3"
            :src="product.images[3]"
            alt="Hình ảnh sản phẩm"
            class="h-full w-full object-cover object-center"
          />
        </div>
        <div class="hidden lg:grid lg:grid-cols-2 lg:gap-x-8">
          <div
            v-if="Array.isArray(product.images) && product.images.length > 3"
            v-for="(image, index) in product.images.slice(4)"
            :key="index"
            class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg"
          >
            <img
              :src="image"
              alt="Hình ảnh sản phẩm"
              class="h-96 w-full object-cover object-center"
            />
          </div>
        </div>
      </div>
      <!-- Product info -->
      <div
        class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16"
      >
        <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
          <h1
            class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"
          >
            {{ product.name }}
          </h1>
        </div>

        <!-- Options -->
        <div class="mt-4 lg:row-span-3 lg:mt-0">
          <h2 class="sr-only">Product information</h2>
          <p class="text-3xl tracking-tight text-gray-900">
            {{ formatPrice(product.price) }}
          </p>

          <!-- Reviews -->
          <div class="mt-6">
            <h3 class="sr-only">Reviews</h3>
            <div class="flex items-center">
              <div class="flex items-center">
                <StarIcon
                  v-for="rating in [0, 1, 2, 3, 4]"
                  :key="rating"
                  :class="[
                    reviews.average > rating
                      ? 'text-gray-900'
                      : 'text-gray-200',
                    'h-5 w-5 flex-shrink-0',
                  ]"
                  aria-hidden="true"
                />
              </div>
              <p class="sr-only">{{ reviews.average }} out of 5 stars</p>
              <a
                :href="reviews.href"
                class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500"
                >{{ reviews.totalCount }} reviews</a
              >
            </div>
          </div>

          <form class="mt-10">
            <button
              type="button"
              @click="handleAddToCart(product)"
              class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
              Thêm vào giỏ hàng
            </button>
          </form>
        </div>

        <div
          class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6"
        >
          <!-- Description and details -->
          <div>
            <h3 class="sr-only">Description</h3>

            <div class="space-y-6">
              <span v-html="product.description" class="text-base text-gray-900"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import { onMounted, ref, inject } from "vue";
import { StarIcon, } from "@heroicons/vue/20/solid";
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";
import { HomeOutlined } from "@ant-design/icons-vue";
import { useRoute } from "vue-router";
import { useRouter } from "vue-router";
import TheHeader from "@/components/TheHeader.vue";
import TheFooter from "@/components/TheFooter.vue";
import { toast } from "vue3-toastify";

const route = useRoute();
const productId = route.params.id;
const apiUrl = inject("apiUrl");

const formatPrice = (price) => {
  // Thêm dấu chấm sau 3 số và thêm VNĐ
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "VND",
    minimumFractionDigits: 0,
  }).format(price);
}

const navigateTo = (path) => {
  router.push(path);
};

const product = ref({});
const getProduct = async () => {
  try {
    const response = await axios.get(`${apiUrl}/product/${productId}`);
    product.value = response.data[0];
    console.log("product name:", product.value.name);
    console.log("image1:", product.value.images[0]);
    console.log("image:", product.value.images);
  } catch (error) {
    console.log(error);
  }
};

async function fetchAndLogData() {
  await getProduct();
  console.log("name:", product.value.name);
}

onMounted(() => {
  fetchAndLogData();
});

const router = useRouter();

import { isLoggedIn } from "./useAuth";

// const cart = inject('cart')
const addToCart = inject('addToCart')

// const handleAddToCart = (product) => {
//   if (!isLoggedIn.value) {
//     router.push("/signin");
//   } else {
//     console.log("Đã đăng nhập");
//     // Thực hiện các hành động khác (ví dụ: thêm sản phẩm vào giỏ hàng)
//     // Thêm sản phẩm vào giỏ hàng
//     // cart.value.push(product);
//     addToCart(product)

//     open.value = false;
//     // Hiển thị thông báo thành công
//     toast(`Đã thêm "${product.name}" vào giỏ hàng thành công!`, {
//       autoClose: 3000,
//       theme: "auto",
//       type: "success",
//       dangerouslyHTMLString: true,
//     });
//     // alert(`Đã thêm "${product.name}" vào giỏ hàng thành công!`);
//   }
// };
const quantity = ref(1);

const handleAddToCart = () => {
  if (quantity.value > product.value.stock) {
    alert(`Chỉ có thể thêm tối đa ${product.value.stock} sản phẩm vào giỏ hàng.`);
    return;
  }

  if (!isLoggedIn.value) {
    router.push("/signin");
  } else {
    console.log("Đã đăng nhập");
    // Thực hiện các hành động khác (ví dụ: thêm sản phẩm vào giỏ hàng)
    const productToAdd = { ...product.value, quantity: quantity.value };
    addToCart(productToAdd);
    quantity.value = 1;
    open.value = false;
    // // Hiển thị thông báo thành công
    // toast(`Đã thêm "${productToAdd.name}" vào giỏ hàng thành công!`, {
    //   autoClose: 3000,
    //   theme: "auto",
    //   type: "success",
    //   dangerouslyHTMLString: true,
    // });
  }
};

const reviews = { href: "#", average: 4, totalCount: 117 };
</script>
