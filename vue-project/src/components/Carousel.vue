<template>
  <div class="carousel-container">
    <carousel :items-to-show="1" :autoplay="2500" :wrapAround="true">
      <slide v-for="(slide, index) in slides" :key="index">
        <template #default>
          <img
            :src="slide.imageUrl"
            :alt="slide.title"
            class="carousel-image"
          />
          <div class="caption">{{ slide.caption }}</div>
        </template>
      </slide>
      <template #addons>
        <navigation />
        <pagination />
      </template>
    </carousel>
  </div>
</template>

<script setup>
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";

const slides = [
  {
    imageUrl:
      // "https://channel.mediacdn.vn/prupload/156/2019/03/img20190326105932082.jpg",
      "https://media.licdn.com/dms/image/C5612AQGP0yS6F8eV7Q/article-inline_image-shrink_1000_1488/0/1520228117896?e=1722470400&v=beta&t=fTpDw9VVAgd877pweqLkTfrtw5VmUr2lfTCAzYYYxNY",
    title: "Image 1",
    caption: "",
  },
  {
    imageUrl:
      // "https://channel.mediacdn.vn/prupload/156/2019/03/img20190326105932082.jpg",
      "https://i.pinimg.com/originals/88/f3/8f/88f38fe568f7e51006156c253e98138f.jpg",
    title: "Image 2",
    caption: "",
  },
  {
    imageUrl:
      // "https://channel.mediacdn.vn/prupload/156/2019/03/img20190326105932082.jpg",
      "https://luxshopping.vn/Uploads/UserFiles/images/banner%20dong%20ho%20frederique%20constaint.png",
    title: "Image 3",
    caption: "",
  },
];
</script>

<style>
.caption {
  bottom: 20px;
  left: 20px;
  color: white;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 10px;
}

.carousel-container {
  position: relative;
  width: 100%;
  height: 92vh; /* 80% of viewport height */
  overflow: hidden; /* Ensure the image does not overflow its container */
}

.carousel-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  top: 0;
  left: 0;
}
</style>
