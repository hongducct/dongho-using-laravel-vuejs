<template>
  <TheHeader />
  <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
    <div class="breadcrumb-section rounded-full">
      <div class="container">
        <div class="row items-center">
          <div class="col-sm-6 content-center">
            <a-breadcrumb separator=">">
              <a-breadcrumb-item @click="navigateTo('/')"  class="flex items-center">
                <div class="flex items-center">
                  <HomeOutlined />
                  <span style="padding-left: 3px;">TRANG CHỦ</span>
                </div>
              </a-breadcrumb-item>
              <a-breadcrumb-item>Kết quả tìm kiếm: "{{ searchTerm }}"</a-breadcrumb-item>
            </a-breadcrumb>
          </div>
        </div>
      </div>
    </div>
    <!-- Your content -->
    <!-- Sản phẩm -->
    <div class="bg-gray-300 mt-10 rounded-lg">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-20 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
          Kết quả tìm kiếm cho: "{{ searchTerm }}"
        </h2>

        <div v-if="filteredProducts.length === 0" class="mt-6 border-2 bg-orange-50 px-4 py-3 border-red-300 text-orange-500">
          <span>Rất tiếc, không tìm thấy sản phẩm phù hợp với lựa chọn của bạn</span>
        </div>
        
        <div v-else class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
          <div v-for="product in filteredProducts" :key="product.id" class="group relative"
            @click="openDialog(product)">
            <div
              class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
              <img :src="product.images[0]" :alt="product.name"
                class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
            </div>
            <div class="mt-4 flex justify-between">
              <div>
                <h3 class="text-sm text-gray-700">{{ product.name }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                  {{ product.brand }}
                </p>
              </div>
              <p class="text-sm font-medium text-gray-900">
                {{ product.price }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
        leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
          <TransitionChild as="template" enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
            enter-to="opacity-100 translate-y-0 md:scale-100" leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 md:scale-100"
            leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">
            <DialogPanel
              class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
              <div
                class="relative flex w-full items-center overflow-hidden bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                <button type="button"
                  class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 sm:right-6 sm:top-8 md:right-6 md:top-6 lg:right-8 lg:top-8"
                  @click="open = false">
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>

                <div class="grid w-full grid-cols-1 items-start gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8">
                  <div class="aspect-h-3 aspect-w-2 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
                    <img :src="selectedProduct.images[0]" :alt="selectedProduct.name"
                      class="object-cover object-center" />
                  </div>
                  <div class="sm:col-span-8 lg:col-span-7">
                    <h2 class="text-2xl font-bold text-gray-900 sm:pr-12">
                      {{ selectedProduct.name }}
                    </h2>

                    <section aria-labelledby="information-heading" class="mt-2">
                      <h3 id="information-heading" class="sr-only">
                        Product information
                      </h3>

                      <p class="text-2xl text-gray-900">
                        {{ selectedProduct.price }} VNĐ
                      </p>

                      <!-- Thêm các thông tin khác của sản phẩm -->
                      <p class="mt-2 text-gray-500 flex items-center">
                        Hãng:
                      <h3 class="ml-2">{{ selectedProduct.brand }}</h3>
                      </p>
                      <!-- <p class="mt-2 text-gray-500">
                            {{ selectedProduct.description }}
                          </p> -->
                      <p class="mt-2 text-gray-500">
                        Số lượng trong kho: {{ selectedProduct.stock }}
                      </p>
                      <p class="mt-2 text-gray-500">
                        Loại sản phẩm: {{ selectedProduct.category }}
                      </p>
                      <p class="mt-2 text-gray-500">
                        Movement: {{ selectedProduct.movement }}
                      </p>
                      <p class="mt-2 text-gray-500">
                        Case: {{ selectedProduct.case }}
                      </p>
                      <p class="mt-2 text-gray-500">
                        Dây đeo: {{ selectedProduct.strap }}
                      </p>
                      <p class="mt-2 text-gray-500">
                        Water Resistance:
                        {{ selectedProduct.water_resistance }}
                      </p>
                    </section>

                    <section aria-labelledby="options-heading" class="mt-10">
                      <h3 id="options-heading" class="sr-only">
                        Product options
                      </h3>

                      <form>
                        <button type="button" @click="handleAddToCart(selectedProduct)"
                          class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                          Thêm vào giỏ hàng
                        </button>
                        <button type="button" @click="
                          navigateToDetailProduct(selectedProduct.id)
                          "
                          class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                          Chi tiết sản phẩm
                        </button>
                      </form>
                    </section>
                  </div>
                </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, computed, inject, onMounted, provide } from "vue";
import { useRoute } from "vue-router";
import { useRouter } from "vue-router";
import { Bars3Icon, BellIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { HomeOutlined, UserOutlined } from "@ant-design/icons-vue";
import {
  Dialog,
  DialogTitle,
  DialogPanel,
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import TheHeader from "@/components/TheHeader.vue";

const route = useRoute();

const router = useRouter();

const navigateTo = (path) => {
  router.push(path);
};

const navigateToDetailProduct = (productId) => {
  router.push({ name: "ProductDetail", params: { id: productId } });
};

//selectedProduct
const selectedProduct = ref(null);

const open = ref(false);
function openDialog(product) {
  // Mở dialog và hiển thị transition root
  open.value = true;
  selectedProduct.value = product; // Gán sản phẩm được chọn vào biến selectedProduct
}

// Thêm vào cart

import { isLoggedIn } from "./useAuth";

const cart = inject('cart')
const handleAddToCart = (product) => {
  if (!isLoggedIn.value) {
    router.push("/signin");
  } else {
    console.log("Đã đăng nhập");
    // Thực hiện các hành động khác (ví dụ: thêm sản phẩm vào giỏ hàng)
    // Thêm sản phẩm vào giỏ hàng
    cart.value.push(product);

    open.value = false;
    // Hiển thị thông báo thành công
    toast(`Đã thêm "${product.name}" vào giỏ hàng thành công!`, {
      autoClose: 3000,
      theme: "auto",
      type: "success",
      dangerouslyHTMLString: true,
    });
    // alert(`Đã thêm "${product.name}" vào giỏ hàng thành công!`);
  }
};
provide("cart", cart);

// Search
const searchTerm = route.query.q || ""; // Lấy từ khóa tìm kiếm từ URL
const products = ref([]); // Danh sách sản phẩm

// Lọc danh sách sản phẩm dựa trên từ khóa tìm kiếm
const filteredProducts = computed(() => {
  return products.value.filter(
    (product) =>
      product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      product.brand.toLowerCase().includes(searchTerm.toLowerCase())
  );
});

// Lấy danh sách sản phẩm từ API
const apiUrl = inject("apiUrl");

const getProducts = () => {
  axios
    .get(`${apiUrl}/products`)
    .then(function (response) {
      // handle success
      products.value = response.data.map((product, index) => ({
        ...product,
        index: index + 1,
      }));
      console.log(products);
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    });
};

console.log("hello");
onMounted(() => {
  getProducts();
});
</script>
<style scoped>
.breadcrumb-section {
  background-color: #f5f5fa;
  padding: 20px 15px;
}

</style>