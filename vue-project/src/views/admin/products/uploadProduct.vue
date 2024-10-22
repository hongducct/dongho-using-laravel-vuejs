<template>
  <a-card title="Form Thêm Sản Phẩm" style="width: 800px">
    <a-form
      :label-col="labelCol"
      :wrapper-col="wrapperCol"
      layout="horizontal"
      style="max-width: 700px"
    >
      <a-form-item
        label="Name"
        :validate-status="errors.name ? 'error' : ''"
        :help="errors.name"
      >
        <a-input v-model:value="formData.name" placeholder="Tên Sản Phẩm" />
      </a-form-item>
      <a-form-item
        label="Brand"
        :validate-status="errors.brand ? 'error' : ''"
        :help="errors.brand"
      >
        <a-input v-model:value="formData.brand" placeholder="Hãng" />
      </a-form-item>
      <a-form-item
        label="Mô tả"
        :validate-status="errors.description ? 'error' : ''"
        :help="errors.description"
      >
        <a-textarea
          v-model:value="formData.description"
          :rows="4"
          placeholder="Mô tả sản phẩm"
        />
      </a-form-item>
      <!-- <a-form-item
        label="Price"
        :validate-status="errors.price ? 'error' : ''"
        :help="errors.price"
      >
        <a-input-number v-model:value="formData.price" />
      </a-form-item> -->
      <a-form-item
        label="Price"
        :validate-status="errors.price ? 'error' : ''"
        :help="errors.price"
      >
        <a-input v-model:value="formattedPrice" @input="onPriceInput" />
      </a-form-item>

      <a-form-item
        label="Stock"
        :validate-status="errors.stock ? 'error' : ''"
        :help="errors.stock"
      >
        <a-input-number v-model:value="formData.stock" />
      </a-form-item>
      <a-form-item
        label="Category"
        :validate-status="errors.category_id ? 'error' : ''"
        :help="errors.category_id"
      >
        <a-select
          v-model:value="formData.category_id"
          style="width: 100%"
          placeholder="Category"
          :options="categories"
          :show-search="true"
          :filter-option="filterOption"
          allow-clear
        ></a-select>
      </a-form-item>
      <a-form-item label="Product Attributes">
        <a-form-item
          label="Movement"
          :validate-status="errors.movement ? 'error' : ''"
          :help="errors.movement"
        >
          <a-input
            v-model:value="formData.movement"
            style="width: 45%"
            placeholder="Movement Value"
          />
        </a-form-item>
        <a-form-item
          label="Case"
          :validate-status="errors.case ? 'error' : ''"
          :help="errors.case"
        >
          <a-input
            v-model:value="formData.case"
            style="width: 45%"
            placeholder="Case Value"
          />
        </a-form-item>
        <a-form-item
          label="Strap"
          :validate-status="errors.strap ? 'error' : ''"
          :help="errors.strap"
        >
          <a-input
            v-model:value="formData.strap"
            style="width: 45%"
            placeholder="Strap Value"
          />
        </a-form-item>
        <a-form-item
          label="WaterResistance"
          :validate-status="errors.water_resistance ? 'error' : ''"
          :help="errors.water_resistance"
        >
          <a-input
            v-model:value="formData.water_resistance"
            style="width: 50%"
            placeholder="Water Resistance Value"
          />
        </a-form-item>
      </a-form-item>

      <!-- Upload Image -->
      <a-form-item
        label="Product Images"
        :validate-status="errors.images ? 'error' : ''"
        :help="errors.images"
      >
        <a-upload-dragger
          v-model:fileList="fileList"
          name="file"
          :progress="progress"
          :multiple="true"
          :action="`${apiUrl}/upload-images`"
          @change="handleChange"
          @drop="handleDrop"
          list-type="picture"
        >
          <p class="ant-upload-drag-icon">
            <InboxOutlined />
          </p>
          <p class="ant-upload-text">
            Click or drag file to this area to upload
          </p>
          <p class="ant-upload-hint">
            Support for a single or bulk upload. Strictly prohibit from
            uploading company data or other band files
          </p>
        </a-upload-dragger>
      </a-form-item>

      <a-form-item label="">
        <a-button type="primary" @click="submitForm">Submit</a-button>
      </a-form-item>
    </a-form>
  </a-card>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { InboxOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";
import axios from "axios";

const fileList = ref([]);

const handleChange = (info) => {
  const status = info.file.status;
  if (status === "done") {
    message.success(`${info.file.name} file added successfully.`);

    if (errors.value.images) {
      delete errors.value.images;
    }
  } else if (status === "error") {
    message.error(`${info.file.name} file failed to add.`);
  }
  fileList.value = [...info.fileList];
};

const progress = {
  strokeColor: {
    "0%": "#108ee9",
    "100%": "#87d068",
  },
  strokeWidth: 3,
  format: (percent) => `${parseFloat(percent.toFixed(2))}%`,
  class: "test",
};
// const beforeUpload = (file) => {
//   const isLessThan2M = file.size / 1024 / 1024 < 3; // Kiểm tra kích thước file nhỏ hơn 2MB
//   if (!isLessThan2M) {
//     message.error("File phải nhỏ hơn 2MB!");
//   }
//   return isLessThan2M;
// };

function handleDrop(e) {
  console.log(e);
}

const categories = ref([]);

import { inject } from "vue";
const apiUrl = inject("apiUrl");
console.log(`${apiUrl}/products/create`);
const getCategories = () => {
  axios
    .get(`${apiUrl}/categories`)
    .then(function (response) {
      categories.value = response.data.categories;
    })
    .catch(function (error) {
      console.log(error);
    });
};

onMounted(() => {
  getCategories();
});

const filterOption = (input, option) => {
  return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

const labelCol = {
  style: {
    width: "180px",
  },
};
const wrapperCol = {
  span: 14,
};

const formData = ref({
  name: "",
  brand: "",
  description: "",
  price: "",
  stock: 0,
  category_id: "",
  movement: "",
  case: "",
  strap: "",
  water_resistance: "",
  images: [],
});

const formattedPrice = ref("");

// Helper function to format numbers with dots as thousands separators
const formatNumber = (num) => {
  return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

// Helper function to parse the formatted number string back to a raw number string
const parseNumber = (str) => {
  return str.replace(/\./g, "");
};

// Event handler for the price input field
const onPriceInput = (event) => {
  const value = event.target.value;
  if (!value) {
    // If the input is empty, reset price to 0 and clear formattedPrice
    formData.value.price = "";
    formattedPrice.value = "";
  } else {
    const numericValue = parseNumber(value);
    // Only update formData.price if numericValue is a valid number
    if (!isNaN(numericValue)) {
      formData.value.price = parseFloat(numericValue);
      formattedPrice.value = formatNumber(numericValue);
    }
  }
};

// Watcher to keep formattedPrice in sync with formData.price
watch(
  () => formData.value.price,
  (newValue) => {
    if (newValue === 0) {
      formattedPrice.value = "";
    } else {
      formattedPrice.value = formatNumber(newValue);
    }
  }
);

const errors = ref([]);

const submitForm = () => {
  console.log("xx", formData.value.name);
  const formDataToSend = new FormData();

  // Thêm các trường dữ liệu khác vào formDataToSend
  formDataToSend.append("name", formData.value.name);
  formDataToSend.append("brand", formData.value.brand);
  formDataToSend.append("description", formData.value.description);
  formDataToSend.append("price", formData.value.price);
  formDataToSend.append("stock", formData.value.stock);
  formDataToSend.append("category_id", formData.value.category_id);
  formDataToSend.append("movement", formData.value.movement);
  formDataToSend.append("case", formData.value.case);
  formDataToSend.append("strap", formData.value.strap);
  formDataToSend.append("water_resistance", formData.value.water_resistance);

  fileList.value.forEach((file) => {
    formDataToSend.append("images[]", file.originFileObj);
  });

  axios
    .post(`${apiUrl}/products`, formDataToSend, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    })
    .then((response) => {
      console.log(response);
      console.log("phần response data", response.data);
      if (response.data.success) {
        // Xóa dữ liệu trong các trường input
        formData.value.name = "";
        formData.value.brand = "";
        formData.value.description = "";
        formData.value.price = 0;
        formData.value.stock = 0;
        formData.value.category_id = "";
        formData.value.movement = "";
        formData.value.case = "";
        formData.value.strap = "";
        formData.value.water_resistance = "";
        fileList.value = []; // Xóa danh sách file đã upload

        // Hiển thị thông báo thành công
        message.success(response.data.message);

        // Tùy chọn: Load lại trang sau khi thêm sản phẩm thành công
        // window.location.reload();
      } else {
        message.error("Đã xảy ra lỗi khi thêm sản phẩm");
      }
    })
    .catch((error) => {
      console.log(error);
      errors.value = error.response.data.errors;
      if (error.response) {
        console.log(error.response.data.errors); // Hiển thị lỗi từ server
      } else if (error.request) {
        console.error("Request error:", error.request);
      } else {
        console.error("Request setup error:", error.message);
      }
    });
};
</script>
