<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
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
                        <a href="" class="btn btn-success">Add Product</a>
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
                            
                            <tr v-for="product in products  " :key="product.id">
                                <td>{{ product.id }}</td>
                                <td>{{ product.title }}</td>
                                <td>{{ product.description }}</td>
                                <td>{{ product.price }}</td>
                                <td>
                                    <img src="" alt="Image" />
                                </td>

                                <td>
                                    <a href="" data-id="">
                                        Edit
                                    </a>
                                    |
                                    <a
                                        href="javascript:void(0)"
                                        id="delete-user"
                                        data-id=""
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
    </div>
</template>
<script>
export default {
    data() {
        return {
            editMode: false,
            products:{},
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
                .get("/product")
                .then( (response)=>{
                    console.log("init-in");
                    console.log(response.product)
                    this.products = response.product
                })
                .catch(error => console.log(error));
            
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
