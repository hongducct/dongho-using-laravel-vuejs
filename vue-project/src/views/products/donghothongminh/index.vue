<template>
  <TheHeader />
  <Carousel />
  <div class="min-h-full bg-zinc-200">
    <main class="mb-5">
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <!-- Your content -->
        <!-- Sản phẩm -->
        <div class="bg-zinc-200">
          <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 bg-gray-300 rounded-md"
            id="products">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
              Đồng hồ thông minh
            </h2>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
              <div v-for="product in paginatedProducts" :key="product.id" class="group relative"
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
                    {{ formatPrice(product.price) }}
                  </p>
                </div>
              </div>
            </div>
            <!-- Phân trang -->
            <div class="flex justify-center mt-6">
              <a-pagination v-model:current="currentPage" :total="totalProducts" :pageSize="pageSize"
                :showSizeChanger="true" :pageSizeOptions="['4', '8', '12', '24', '36', '48', '60']"
                :showQuickJumper="true" @change="handlePageChange" @showSizeChange="handleSizeChange" />
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
                      <div
                        class="aspect-h-3 aspect-w-2 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
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
                            {{ formatPrice(selectedProduct.price) }}
                          </p>

                          <!-- Thêm các thông tin khác của sản phẩm -->
                          <p class="mt-2 text-gray-500 flex items-center">
                            Hãng:
                          <h3 class="ml-2">{{ selectedProduct.brand }}</h3>
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
                          <p class="mt-2 text-gray-500">
                            Số lượng trong kho: {{ selectedProduct.stock }}
                          </p>
                        </section>

                        <section aria-labelledby="options-heading" class="mt-10">
                          <h3 id="options-heading" class="sr-only">
                            Product options
                          </h3>

                          <form>
                            <div class="flex items-center space-x-1">
                              <button type="button"
                                class="inline-flex items-center justify-center w-10 h-10 border hover:bg-indigo-200  rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                @click="decreaseQuantity" :disabled="quantity <= 1">
                                -
                              </button>
                              <input type="text" class="w-10 h-10 border border-gray-300 text-center rounded"
                                v-model.number="quantity" readonly />
                              <button type="button"
                                class="inline-flex items-center justify-center w-10 h-10 border hover:bg-indigo-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                @click="increaseQuantity" :disabled="quantity >= selectedProduct.stock">
                                +
                              </button>
                            </div>

                            <!-- <button type="button" @click="handleAddToCart(selectedProduct)"
                              :disabled="quantity > selectedProduct.stock"
                              class="mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                              Thêm vào giỏ hàng
                            </button> -->

                            <button type="button" @click="handleAddToCart" :disabled="quantity > selectedProduct.stock"
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
    </main>
  </div>

  <!-- Short link -->
  <!-- FLOAT BUTTON  -->
  <div class="fixed bottom-0 right-0 z-50">
    <a-back-top :style="{ bottom: '100px' }" />
    <!-- <a-float-button :style="{bottom: '200px'}"  /> -->
    <a-float-button-group trigger="hover" type="primary">
      <template #icon>
        <CustomerServiceOutlined />
      </template>
      <a-float-button @click="redirectToFacebook" />
      <a-float-button @click="redirectToFacebook">
        <template #icon>
          <CommentOutlined />
        </template>
      </a-float-button>
    </a-float-button-group>
  </div>
</template>


<script setup>
import { Bars3Icon, BellIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { onMounted, ref, h, inject, computed, provide } from "vue";
import { useStore } from "vuex";
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
import { StarIcon } from "@heroicons/vue/20/solid";
import { CustomerServiceOutlined, CommentOutlined } from '@ant-design/icons-vue';
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import TheHeader from "@/components/TheHeader.vue";
import TheFooter from "@/components/TheFooter.vue";
import Carousel from "@/components/Carousel.vue";

const router = useRouter();

const navigateToDetailProduct = (productId) => {
  router.push({ name: "ProductDetail", params: { id: productId } });
};

const formatPrice = (price) => {
  // Thêm dấu chấm sau 3 số và thêm VNĐ
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "VND",
    minimumFractionDigits: 0,
  }).format(price);
}

import { isLoggedIn, setIsLoggedIn } from '@/views/useAuth';

const loggedInFromStorage = localStorage.getItem('isLoggedIn') === 'true';
setIsLoggedIn(loggedInFromStorage);


// Nhận cart từ provide
const cart = inject('cart');
const addToCart = inject('addToCart');
const removeFromCart = inject('removeFromCart');
const clearCart = inject('clearCart');
const getTotalPrice = inject('getTotalPrice');

// const handleAddToCart = (product) => {
//   if (!isLoggedIn.value) {
//     router.push("/signin");
//   } else {
//     console.log("Đã đăng nhập");
//     // Thực hiện các hành động khác (ví dụ: thêm sản phẩm vào giỏ hàng)
//     // Thêm sản phẩm vào giỏ hàng
//     // cart.value.push(product);
//     addToCart(product);
//     console.log('xx',cart)
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


const products = ref([]);
const apiUrl = inject("apiUrl");

// const getProducts = () => {
//   axios
//     .get(`${apiUrl}/products-category/4`)
//     .then(function (response) {
//       // handle success
//       products.value = response.data.map((product, index) => ({
//         ...product,
//         index: index + 1,
//       }));
//       console.log(products);
//     })
//     .catch(function (error) {
//       // handle error
//       console.log(error);
//     });
// };

const getProducts = () => {
  axios
    .get(`${apiUrl}/products-category/4`)
    .then(function (response) {
      products.value = response.data.map((product, index) => ({
        ...product,
        index: index + 1,
      }));
      totalProducts.value = response.data.length;
    })
    .catch(function (error) {
      console.log(error);
    });
};

console.log("hello");
onMounted(() => {
  getProducts();
});

console.log(products);

const open = ref(false);

const selectedProduct = ref(null); // Thêm biến selectedProduct

function openDialog(product) {
  // Mở dialog và hiển thị transition root
  open.value = true;
  selectedProduct.value = product; // Gán sản phẩm được chọn vào biến selectedProduct
}

const redirectToFacebook = () => {
  // window.location.href = 'https://www.facebook.com/hongducct23'; // Thay thế URL của trang Facebook của bạn ở đây
  window.open('https://www.facebook.com/hongducct23', '_blank');
};

const quantity = ref(1);

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--;
  }
};

const increaseQuantity = () => {
  if (quantity.value < selectedProduct.value.stock) {
    quantity.value++;
  }
};
const handleAddToCart = () => {
  if (quantity.value > selectedProduct.value.stock) {
    alert(`Chỉ có thể thêm tối đa ${selectedProduct.value.stock} sản phẩm vào giỏ hàng.`);
    return;
  }

  if (!isLoggedIn.value) {
    router.push("/signin");
  } else {
    console.log("Đã đăng nhập");
    // Thực hiện các hành động khác (ví dụ: thêm sản phẩm vào giỏ hàng)
    const productToAdd = { ...selectedProduct.value, quantity: quantity.value };
    addToCart(productToAdd);
    quantity.value = 1;
    console.log('xx', cart);
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

const currentPage = ref(1);
const productsPerPage = ref(12);
const totalProducts = ref(0);

const paginatedProducts = computed(() => {
  const startIndex = (currentPage.value - 1) * pageSize.value;
  const endIndex = startIndex + pageSize.value;
  return products.value.slice(startIndex, endIndex);
});

const pageSize = ref(productsPerPage);

const handleSizeChange = (current, size) => {
  currentPage.value = 1; // Reset trang hiện tại về 1
  pageSize.value = size; // Cập nhật pageSize
};

const handlePageChange = (page) => {
  currentPage.value = page;
};
</script>