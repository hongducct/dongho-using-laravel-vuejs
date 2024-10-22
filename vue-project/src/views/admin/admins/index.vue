<template>
  <div>
    <a-card title="tài khoản admins" style="width: 90%">
      <div class="flex items-center justify-between">
        <!-- Search bar -->
        <SearchForm @search="handleSearch" />
      </div>
      <div class="row">
        <div class="col-12">
          <a-button type="link" @click="showCreateModal">
            Thêm mới admin
          </a-button>
          <br /><br />
          <a-table
            :dataSource="filteredItems"
            :columns="columns"
            :scroll="{ x: 500, y: tableHeight }"
          >
            <template #bodyCell="{ column, index, record }">
              <template v-if="column.key === 'index'">
                <span>{{ index + 1 }}</span>
              </template>
              <template v-if="column.key === 'avatar'">
                <a-image
                  :height="90"
                  :width="90"
                  class="object-cover"
                  :src="`http://192.168.23.1:8000/storage/${record.avatar}`"
                />
              </template>
              <template v-if="column.key === 'action'">
                <!-- Xóa admin -->
                <a-button type="link" danger @click="deleteAdmin(record.id)"
                  >Xóa</a-button
                >
              </template>
            </template>
          </a-table>
          <a-modal
            v-model:open="addModelVisible"
            :model="formState"
            title="Thêm mới admin"
            @ok="handleCreate"
            @cancel="handleCancel"
          >
            <a-form
              :label-col="{ span: 8 }"
              :wrapper-col="{ span: 16 }"
              style="width: 80%"
              autocomplete="off"
            >
              <a-form-item
                label="Email"
                name="email"
                :validate-status="errors.email ? 'error' : ''"
                :help="errors.email"
              >
                <a-input v-model:value="formState.email" placeholder="Email" />
              </a-form-item>
              <a-form-item
                label="Username"
                name="username"
                :validate-status="errors.username ? 'error' : ''"
                :help="errors.username"
              >
                <a-input
                  v-model:value="formState.username"
                  placeholder="Username"
                />
              </a-form-item>
              <a-form-item
                label="Tên"
                name="name"
                :validate-status="errors.name ? 'error' : ''"
                :help="errors.name"
              >
                <a-input v-model:value="formState.name" placeholder="Tên" />
              </a-form-item>
              <a-form-item
                label="Password"
                name="password"
                :validate-status="errors.password ? 'error' : ''"
                :help="errors.password"
              >
                <a-input-password v-model:value="formState.password" />
              </a-form-item>
              <!-- Upload Avatar -->
              <a-form-item label="Avatar">
                <a-upload-dragger
                  name="file"
                  :progress="progress"
                  :multiple="false"
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
              <!-- Add this new form item -->
              <a-form-item name="avatar">
                <input type="hidden" v-model="formState.avatar" />
              </a-form-item>
            </a-form>
          </a-modal>
        </div>
      </div>
    </a-card>
  </div>
</template>

<script setup>
import { onMounted, ref, computed, inject } from "vue";
import { message } from "ant-design-vue";
import { InboxOutlined } from "@ant-design/icons-vue";
import axios from "axios";

const tableHeight = inject("tableHeight");

const users = ref([]);
const admins = ref([]);
const columns = [
  {
    title: "STT",
    // dataIndex: 'id',
    key: "index",
    width: "60px",
  },
  {
    title: "username",
    dataIndex: "username",
    key: "username",
    width: "200px",
  },
  {
    title: "Email",
    dataIndex: "email",
    key: "email",
    width: "300px",
  },
  {
    title: "Avatar",
    dataIndex: "avatar",
    key: "avatar",
    width: "150px",
  },
  {
    title: "Tên",
    dataIndex: "name",
    key: "name",
    width: "180px",
  },
  {
    title: "Action",
    key: "action",
    fixed: "right",
    width: "80px",
  },
];
console.log(columns);

//Search
import SearchForm from "@/components/SearchForm.vue";

const searchFilter = ref("");

const handleSearch = (search) => {
  searchFilter.value = search;
};

const filteredItems = computed(() => {
  return admins.value.filter((item) => {
    const searchTerm = searchFilter.value.toLowerCase();
    return (
      item.username.toLowerCase().includes(searchTerm) ||
      item.email.toLowerCase().includes(searchTerm)
    );
  });
});
// ...

const deleteAdmin = (id) => {
  //Xóa admin
  const confirm = window.confirm("Bạn có chắc chắn muốn xóa admin này?");
  if (confirm) {
    axios
      .delete(`${apiUrl}/admins/${id}`)
      .then((res) => {
        console.log(res);
        message.success("Xóa admin thành công");
        // Xóa admin khỏi danh sách
        admins.value = admins.value.filter((admin) => admin.id !== id);
      })
      .catch((err) => {
        console.log(err);
      });
  }
};

const formState = ref({
  email: "",
  username: "",
  name: "",
  password: "",
  avatar: "",
});

const addModelVisible = ref(false);
const showCreateModal = () => {
  addModelVisible.value = true;
};

const handleCancel = () => {
  addModelVisible.value = false;
};

const errors = ref([]);
const handleCreate = () => {
  console.log("ok");
  console.log("formState:", formState.value);
  const formData = new FormData();
  formData.append("avatar", formState.value.avatar);
  formData.append("username", formState.value.username);
  formData.append("name", formState.value.name);
  formData.append("email", formState.value.email);
  formData.append("password", formState.value.password);

  console.log(formData); // Gọi formData ở đây

  // Gửi FormData lên Laravel
  axios
    .post(`${apiUrl}/admins`, formData)
    .then((response) => {
      console.log(response);
      message.success("Thêm mới admin thành công");
      addModelVisible.value = false;
      getAdmin();
    })
    .catch((error) => {
      console.log(error);
      message.error("Thêm mới admin thất bại");
      errors.value = error.response.data.errors;
    });
};
const handleChange = (info) => {
  const status = info.file.status;
  if (status === "done") {
    message.success(`${info.file.name} file added successfully.`);

    formState.value.avatar = info.file.originFileObj;
    console.log("xx:", formState.value.avatar);
    console.log(formState); // Assign the file object
  } else if (status === "error") {
    message.error(`${info.file.name} file failed to add.`);
  }
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
function handleDrop(e) {
  console.log(e);
}

const apiUrl = inject("apiUrl");
console.log(apiUrl);
const getUser = () => {
  axios
    .get(`${apiUrl}/users`)
    .then(function (response) {
      // handle success
      users.value = response.data.data;
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    });
};
const getAdmin = () => {
  axios
    .get(`${apiUrl}/admins`)
    .then(function (response) {
      // handle success
      admins.value = response.data;
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    });
};
onMounted(() => {
  getUser();
  getAdmin();
});
</script>
