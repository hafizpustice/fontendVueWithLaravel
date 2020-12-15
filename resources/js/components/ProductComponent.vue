<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Product</strong>
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Product List</h3>
          <div class="add-product">
            <button
              type="button"
              class="btn btn-success"
              data-toggle="modal"
              data-target="#productModal"
            >
              Add Product
            </button>
          </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th width="5%">ID</th>
                <th width="35%">Title</th>
                <th width="10%">price</th>
                <th width="30%">Image</th>
                <th width="20%">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.title }}</td>
                <td>{{ product.price }}</td>
                <td>
                  <img src="" alt="Image" />
                </td>

                <td>
                  <a href="" data-id=""> Edit </a>
                  |
                  <a href="javascript:void(0)" id="delete-user" data-id="">
                    Delete
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade bd-example-modal-lg"
      tabindex="-1"
      id="productModal"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Create Product</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              @submit.prevent="editMode ? updateProduct() : createProduct()"
              method="post"
              enctype="multipart/form-data"
            >
              <div class="card-body">
                <div class="form-group">
                  <label for="">Product title</label>
                  <input
                    type="text"
                    name="title"
                    v-model="form.title"
                    class="form-control"
                    placeholder="Enter email"
                  />
                </div>

                <div class="form-group">
                  <label for="">Description</label>
                  <textarea
                    type="text"
                    name="description"
                    v-model="form.description"
                    class="form-control"
                  ></textarea>
                </div>
                <div class="form-group">
                  <label>Price</label>
                  <input
                    type="number"
                    name="price"
                    v-model="form.price"
                    class="form-control"
                    placeholder="product price"
                  />
                </div>
                <div class="form-group">
                  <label>Image</label>
                  <input
                    type="file"
                    name="image"
                    @change="uploadImage"
                    class="form-control"
                    id="image"
                  />
                </div>
                <div class="image-preview">
                  <img
                    :src="form.image"
                    alt="preview Image"
                    id="image_preview_container"
                  />
                </div>
                <div
                  class="imagePreviewWrapper"
                  :style="{ 'background-image': `url(${previewImage})` }"
                  @click="selectImage"
                ></div>

                <input ref="fileInput" type="file" @input="pickFile" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      previewImage: null,
      url: "",
      editMode: false,
      products: {},
      form: new Form({
        id: "",
        title: "",
        description: "",
        price: "",
        image: "",
      }),
    };
  },
  methods: {
    init: function () {
      this.form
        .get("api/product")
        .then((response) => {
          console.log("init-in");
          console.log(response.data);
          this.products = response.data;
        })
        .catch((error) => console.log(error));
    },
    createProduct: function () {
      console.log(this.form);
      this.form.post("/product");
    },
    uploadImage: function (e) {
      console.log("image");
      let file = e.target.files[0];
      this.form.image = URL.createObjectURL(file);
      console.log(URL.createObjectURL(file));
      let reader = new FileReader();

      // reader.onloadend = (file) => {
      //   //console.log('RESULT', reader.result)
      //   this.form.image = reader.result;
      //   console.log(reader.result);
      // };
      //reader.readAsDataURL(file);
    },
    getImage: function () {
      let image = this.form.image;
      return image;
    },
    selectImage() {
      this.$refs.fileInput.click();
    },
    pickFile() {
      let input = this.$refs.fileInput;
      console.log(input);
      let file = input.files;
      console.log(file);
      console.log(file[0].name);
      if (file && file[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
          console.log("onload");
          this.previewImage = e.target.result;
          this.from.image = e.target.result;
          console.log(this.previewImage);
        };
        reader.readAsDataURL(file[0]);
        this.$emit("input", file[0]);
      }
    },
  },

  // created() {
  //     this.loadCategory();
  // }

  mounted() {
    console.log("init");
    this.init();
  },
  computed: {},
};
</script>
