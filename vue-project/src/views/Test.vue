<template>
  <TheHeader />
  <img src='https://qr.sepay.vn/img?acc=0799076901&bank=MBBANK&amount=20000&des=TOANTEST' class="p-12"/>
</template>

<script setup>
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";

import TheHeader from "@/components/TheHeader.vue";

const slides = [
  {
    imageUrl:
      "https://live.staticflickr.com/65535/53662354025_4c7f72cc38_k.jpg",
    title: "Image 1",
    caption: "This is the caption for Image 1",
  },
  {
    imageUrl:
      "https://live.staticflickr.com/65535/53662107463_3e256f835c_h.jpg",
    title: "Image 2",
    caption: "This is the caption for Image 2",
  },
  // Thêm 8 đối tượng khác cho 8 ảnh còn lại
];
</script>

<style>
.caption {
  position: absolute;
  bottom: 20px;
  left: 20px;
  color: white;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 10px;
}
</style>

// const product = ref([]);
// const route = useRoute();
// const productId = route.params.id;
// const apiUrl = inject("apiUrl");

// const getProducts = () => {
//   axios
//     .get(`${apiUrl}/product/${productId}`)
//     .then(function (response) {
//       // handle success
//       product.value = response.data.map((product, index) => ({
//         ...product,
//         index: index + 1,
//       }));
//       console.log('product:',product);
//     })
//     .catch(function (error) {
//       // handle error
//       console.log(error);
//     });
// };
// console.log("hello");
// onMounted(() => {
//   getProducts();
// });