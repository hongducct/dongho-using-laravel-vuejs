<template>
  <div class="qrcode-container">
    <div align="center">
      <a-space
        direction="vertical"
        style="background-color: white; padding: 30px; border: 1px solid red"
      >
        <a-qrcode
          :value="text"
          :size="size"
          :icon-size="size / 4"
          error-level="H"
          :icon="userImageUrl"
          />
          <!-- icon="https://scontent.fhan15-1.fna.fbcdn.net/v/t39.30808-6/428667964_1774859043023937_3129338270249836026_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeH12lVtiRFc0YNK7h-eDoV3P9BqAQCRWts_0GoBAJFa2_Eb03OvCy0qaiDsmcXVTZNepEMR4A6d06QfrvDDdJNT&_nc_ohc=ECTWZEULNdsAb65zn3x&_nc_ht=scontent.fhan15-1.fna&oh=00_AfBEebEve1cEwcQct03RD4_32MCtNNmknXBY9dP9G3xdsg&oe=6621820F" -->
        <a-input
          v-model:value="text"
          placeholder="Nhập vào đây"
          :maxlength="80"
        />
      </a-space>
    </div>
    <br /><br />

    <a-popover :overlay-inner-style="{ padding: 0 }" direction="vertical">
      <template #content>
        <a-qrcode
          ref="qrcodeCanvasRef"
          value="https://www.instagram.com/hongducct/"
          :size="size / 1.5"
          :icon="userImageUrl"
          :bordered="false"
          />
          <!-- icon="https://scontent.fhan15-1.fna.fbcdn.net/v/t39.30808-6/428667964_1774859043023937_3129338270249836026_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeH12lVtiRFc0YNK7h-eDoV3P9BqAQCRWts_0GoBAJFa2_Eb03OvCy0qaiDsmcXVTZNepEMR4A6d06QfrvDDdJNT&_nc_ohc=ECTWZEULNdsAb65zn3x&_nc_ht=scontent.fhan15-1.fna&oh=00_AfBEebEve1cEwcQct03RD4_32MCtNNmknXBY9dP9G3xdsg&oe=6621820F" -->
      </template>
      <img width="500" height="500" :src="userImageUrl" />
      <!-- src="https://scontent.fhan15-1.fna.fbcdn.net/v/t39.30808-6/428667964_1774859043023937_3129338270249836026_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeH12lVtiRFc0YNK7h-eDoV3P9BqAQCRWts_0GoBAJFa2_Eb03OvCy0qaiDsmcXVTZNepEMR4A6d06QfrvDDdJNT&_nc_ohc=ECTWZEULNdsAb65zn3x&_nc_ht=scontent.fhan15-1.fna&oh=00_AfB8bcykLjCW1p9sPeofzvU_3Qvt11Btf9vE1PhSCz1Wyg&oe=6621118F" -->
    </a-popover>
  </div>
</template>
<script setup>
import { ref, computed } from "vue";
const size = ref(300);
const text = ref("https://www.instagram.com/hongducct/");

// Lấy admin từ localStorage
const admin = ref(JSON.parse(localStorage.getItem("admin")));
console.log(admin.value);

const baseURL = "http://192.168.23.1:8000/storage/";
// Computed property để lấy đường dẫn ảnh đại diện
const userImageUrl = computed(() => {
  return admin.value.avatar ? `${baseURL}${admin.value.avatar}` : "";
});

console.log(userImageUrl.value);

</script>

<style scoped>
.qrcode-container {
  margin: 30px auto;
  padding-bottom: 100px;
  max-width: 500px;
}
input {
  width: 300px;
  margin-top: 10px;
  text-align: center;
}
</style>
