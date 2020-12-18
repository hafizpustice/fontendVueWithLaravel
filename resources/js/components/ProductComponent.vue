<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product List</h3>
                    <div class="add-product">
                        <button
                            class="btn btn-success"
                            data-toggle="modal"
                            @click="showModal"
                            data-target="#addProduct"
                        >
                            Add Product<i class="fas fa-user-plus fa-fw"></i>
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
                                    <img
                                        :src="product.image"
                                        class="table-image"
                                        alt="Image"
                                    />
                                </td>

                                <td>
                                    <a
                                        href="#"
                                        data-id="post.id"
                                        @click.prevent="update(product)"
                                    >
                                        Edit
                                    </a>
                                    |
                                    <a
                                        href="#"
                                        @click.prevent="deletePost(product.id)"
                                    >
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

        <!-- Modal  -->
        <div
            class="modal fade"
            id="addProduct"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addNewLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewLabel">
                            Add New Product
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form
                        @submit.prevent="editMode ? updatePost() : createPost()"
                        enctype="multipart/form-data"
                        @keydown="form.onKeydown($event)"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Product Title</label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    name="title"
                                    placeholder="title"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('title')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="title"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea
                                    type="text"
                                    name="description"
                                    v-model="form.description"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'description'
                                        )
                                    }"
                                ></textarea>
                                <has-error
                                    :form="form"
                                    field="description"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input
                                    type="number"
                                    name="price"
                                    v-model="form.price"
                                    class="form-control"
                                    placeholder="Enter product price"
                                    :class="{
                                        'is-invalid': form.errors.has('price')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="price"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input
                                    type="file"
                                    name="image"
                                    @change="uploadPhoto"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('price')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="image"
                                ></has-error>
                            </div>
                            <div class="image-preview">
                                <img
                                    :src="getPhoto()"
                                    alt="preview Image"
                                    id="image_preview_container"
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                id="btnSave"
                                class="btn btn-primary"
                            >
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            toastMessage: "",
            editMode: false,
            image: null,
            products: {},
            form: new Form({
                id: "",
                title: "",
                description: "",
                price: "",
                image: ""
            })
        };
    },
    methods: {
        init: function() {
            this.form
                .get("product")
                .then(response => {
                    console.log("init-in");
                    console.log(response.data);
                    this.toastMessage = response.data.message;
                    this.products = response.data.data;
                })
                .catch(error => console.log(error));
        },
        uploadPhoto(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file["size"] < 2111775) {
                reader.onloadend = file => {
                    this.form.image = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                alert("File size can not be bigger than 2 MB");
            }
        },
        //For getting Instant Uploaded Photo
        getPhoto() {
            //let photo = (this.form.photo.length > 100) ? this.form.photo : "img/profile/"+ this.form.photo;
            let image = this.form.image;
            return image;
        },
        createPost() {
            console.log("created");
            this.form
                .post("/product")
                .then(response => {
                    Toast.fire({
                        icon: "success",
                        title: "post created successfully"
                    });

                    $("#addProduct").modal("hide");
                    this.init();
                })
                .catch(error => console.log(error));
        },
        update(product) {
            console.log("update function");
            this.editMode = true;
            this.form.reset();
            this.form.fill(product);
            console.log(product);

            $("#addProduct").modal("show");
            $("#btnSave").html("Update");
            $("#addNewLabel").html("Update Product");
        },
        deletePost(id) {
             Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result)=>{
                    if(result.value){
                        this.form.delete('product/'+id)
                        .then((response)=>{
                            Swal.fire(
                              'Deleted!',
                              'Product deleted successfully',
                              'success'
                            )
                            console.log('response')
                            this.init();
                        }).catch(()=>{
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!',
                              footer: '<a href>Why do I have this issue?</a>'
                            })

                        })
                    }
                })
        },

        updatePost() {
            console.log("update");
            console.log("created");
            this.form
                .put("/product/" + this.form.id)
                .then(response => {
                      Toast.fire({
                            icon: 'success',
                            title: 'Product Updated successfully'
                        })
                    console.log("create producr");
                    $("#addProduct").modal("hide");
                    this.init();
                    this.editMode = false;
                })
                .catch(error => console.log(error));
        },
        showModal: function() {
            console.log("show modal");
             $("#btnSave").html("Create");
            $("#addNewLabel").html("Create Product");
            this.form.reset();
            $("#addProduct").modal("show");
        },

        selectFile(event) {
            console.log("event");
            this.image = event.target.files[0];
        }
    },

    // created() {
    //     this.loadCategory();
    // }

    mounted() {
        console.log("init");
        this.init();
    },
    computed: {}
};
</script>
