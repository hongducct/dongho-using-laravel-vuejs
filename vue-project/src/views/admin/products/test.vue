<template>
    <a-card title="Danh Sách Sản Phẩm" style="width: 100%">
      <div class="flex items-center justify-between">
        <!-- Search bar -->
        <SearchForm @search="handleSearch" />
  
      </div>
      <a-table
        :columns="acolumns"
        :dataSource="filteredItems"
        :scroll="{ x: 1500, y: 600 }"
        @handleRowClick="handleRowClick"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.key === 'images'">
            <span v-for="(image, imageIndex) in record.images" :key="imageIndex">
              <a-image :width="100" :src="image" />
            </span>
          </template>
          <template v-if="column.key === 'action'">
            <!-- Sửa sản phẩm -->
            <a-button type="link" @click="showEditModal(record)">Sửa</a-button>
            <!-- Xóa sản phẩm -->
            <a-button type="link" danger @click="deleteProduct(record.id)"
              >Xóa</a-button
            >
          </template>
        </template>
      </a-table>
    </a-card>
  
    <a-modal
      v-model:open="editModalVisible"
      title="Sửa sản phẩm"
      @ok="handleUpdate"
      @cancel="handleCancel"
      style="width: 80%"
    >
      <a-table
        :columns="editColumns"
        :dataSource="[editingProduct]"
        :scroll="{ x: 1500, y: 600 }"
      >
        <template #bodyCell="{ column, record }">
          <template v-if="column.key === 'images'">
            <a-upload
              :action="`${apiUrl}/upload-images`"
              list-type="picture-card"
              @preview="handlePreview"
              @remove="handleRemove"
            >
              <div v-if="fileList.length < 8">
                <plus-outlined />
                <div style="margin-top: 8px">Upload</div>
              </div>
            </a-upload>
            <a-modal
              :open="previewVisible"
              :title="previewTitle"
              :footer="null"
              @cancel="handleCancel"
            >
              <img alt="example" style="width: 100%" :src="previewImage" />
            </a-modal>
          </template>
          <template v-else>
            <a-input v-model:value="editingProduct[column.dataIndex]" />
          </template>
        </template>
      </a-table>
    </a-modal>
  </template>
  
  <script setup>
  import { onMounted, ref, h, inject, computed } from "vue";
  import {
    CloseCircleOutlined,
    UploadOutlined,
    PlusOutlined,
  } from "@ant-design/icons-vue";
  import { toast } from "vue3-toastify";
  
  import SearchForm from "@/components/SearchForm.vue";
  
  const searchFilter = ref("");
  
  const handleSearch = (search) => {
    searchFilter.value=search;
  };
  
  const filteredItems = computed(() => {
    return products.value.filter((item) => {
      const searchTerm = searchFilter.value.toLowerCase();
      return item.name.toLowerCase().includes(searchTerm) || item.brand.toLowerCase().includes(searchTerm);
    });
  });
  
  const products = ref([]);
  const columns = [
    {
      title: "STT",
      dataIndex: "index",
      key: "index",
      fixed: "left",
      width: "50px",
    },
    {
      title: "Tên sản phẩm",
      dataIndex: "name",
      key: "name",
      width: "150px",
      fixed: "left",
    },
    {
      title: "Thương hiệu",
      dataIndex: "brand",
      key: "brand",
      width: "100px",
    },
    {
      title: "Mô tả",
      dataIndex: "description",
      key: "description",
      width: "400px",
    },
    {
      title: "Giá",
      dataIndex: "price",
      key: "price",
      width: "150px",
    },
    {
      title: "Số lượng trong kho",
      dataIndex: "stock",
      key: "stock",
      width: "100px",
    },
    {
      title: "Loại sản phẩm",
      dataIndex: "category",
      key: "category",
      width: "100px",
    },
    {
      title: "Movement",
      dataIndex: "movement",
      key: "movement",
      width: "100px",
    },
    {
      title: "Case",
      dataIndex: "case",
      key: "case",
      width: "100px",
    },
    {
      title: "Dây đeo",
      dataIndex: "strap",
      key: "strap",
      width: "100px",
    },
    {
      title: "Water Resistance",
      dataIndex: "water_resistance",
      key: "water_resistance",
      width: "100px",
    },
    {
      title: "Hình ảnh",
      dataIndex: "images",
      key: "images",
      width: "450px",
    },
    {
      title: "Action",
      key: "action",
      fixed: "right",
      width: "100px",
    },
  ];
  
  function getBase64(file) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = (error) => reject(error);
    });
  }
  
  const acolumns = computed(() => {
    return columns.filter((col) => col.key !== "description" && col.key !== "movement"
    && col.key !== "case" && col.key !== "strap" && col.key !== "water_resistance");
  });
  
  const editColumns = computed(() => {
    return columns.filter((col) => col.key !== "action" && col.key !== "index");
  });
  
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
        console.log("products:", products);
      })
      .catch(function (error) {
        // handle error
        console.log(error);
      });
  };
  
  const handleRemove = (file) => {
    const index = editingProduct.value.images.indexOf(file.url);
    if (index !== -1) {
      editingProduct.value.images.splice(index, 1);
      console.log("fileList1:", fileList);
    }
  };
  
  const previewVisible = ref(false);
  const previewImage = ref("");
  const previewTitle = ref("");
  
  const fileList = computed(() => {
    if (
      editingProduct.value &&
      editingProduct.value.images &&
      Array.isArray(editingProduct.value.images)
    ) {
      return editingProduct.value.images.map((url, index) => ({
        uid: index.toString(),
        name: "image.png",
        status: "done",
        url,
      }));
    } else {
      return [];
    }
  });
  
  const editModalVisible = ref(false);
  const editingProduct = ref(null);
  
  const showEditModal = (product) => {
    editingProduct.value = { ...product }; // Tạo bản sao của sản phẩm để sửa đổi
    editModalVisible.value = true;
    console.log("editingProduct:", editingProduct);
    console.log("editingProduct image:", editingProduct.value.images);
  };
  
  const handleUpdate = () => {
    // Gửi yêu cầu cập nhật sản phẩm đến server
    console.log("Cập nhật sản phẩm:", editingProduct.value);
    axios
    .put(`${apiUrl}/product/${editingProduct.value.id}`, editingProduct.value)
    .then(function (response) {
      // handle success
      console.log("handleUpdate response:", response);
      toast.success("Cập nhật sản phẩm thành công");
      editModalVisible.value = false;
      getProducts();
    })
    .catch(function (error) {
      // handle error
      console.log(error);
      toast.error("Cập nhật sản phẩm thất bại");
    });
    editModalVisible.value = false;
  };
  
  const handleCancel = () => {
    previewVisible.value = false;
    previewTitle.value = "";
  };
  
  const handlePreview = async (file) => {
    if (!file.url && !file.preview) {
      file.preview = await getBase64(file.originFileObj);
    }
    previewImage.value = file.url || file.preview;
    previewVisible.value = true;
    previewTitle.value =
      file.name || file.url.substring(file.url.lastIndexOf("/") + 1);
  };
  
  const deleteProduct = (id) => {
    console.log("deleteProduct", id);
    if (window.confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
  
      axios
      .delete(`${apiUrl}/product/${id}`)
      .then(function (response) {
        // handle success
        console.log("deleteProduct response:", response);
        getProducts();
      toast(`Đã xóa sản phẩm thành công!`, {
        autoClose: 3000,
        theme: "auto",
        type: "success",
        dangerouslyHTMLString: true,
      });
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    });
    }
  };
  
  onMounted(() => {
    getProducts();
  });
  </script>
  