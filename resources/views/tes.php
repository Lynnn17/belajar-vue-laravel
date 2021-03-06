<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>Product Lists</title>
</head>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
                    <!-- Modal Add New Product -->
                    <template>
                        <v-dialog v-model="dialogAdd" persistent max-width="600px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn color="primary" dark v-bind="attrs" v-on="on">
                                    Add New
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">Add New Product</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field label="Product Name*" v-model="productName" required>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field label="Price*" v-model="productPrice" required>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    <small>*indicates required field</small>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="dialogAdd = false">Close</v-btn>
                                    <v-btn color="blue darken-1" text @click="saveProduct">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </template>

                    <!-- Modal Update Product -->
                    <template>
                        <v-dialog v-model="dialogEdit" persistent max-width="600px">
                            <v-card>
                                <v-card-title>
                                    <span class="headline">Update Product</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field label="Product Name*" v-model="productNameEdit" required>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field label="Price*" v-model="productPriceEdit" required>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    <small>*indicates required field</small>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="dialogEdit = false">Close</v-btn>
                                    <v-btn color="blue darken-1" text @click="updateProduct">Update</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </template>




                    <!-- Modal Delete Product -->
                    <template>
                        <v-dialog v-model="dialogDelete" persistent max-width="600px">
                            <v-card>
                                <v-card-title>
                                    <span class="headline"></span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <h2>Are sure want to delete {{ productNameDelete }} ?</h2>
                                        </v-row>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="blue darken-1" text @click="dialogDelete = false">No</v-btn>
                                    <v-btn color="info darken-1" text @click="deleteProduct">Yes
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </template>

                    <template>
                        <v-simple-table>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">#</th>
                                        <th class="text-left">Product Name</th>
                                        <th class="text-left">Price</th>
                                        <th class="text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products" :key="product.product_id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ product.nama_barang }}</td>
                                        <td>{{ product.product_price }}</td>
                                        <td>
                                            <v-btn color="info" depressed small @click="getEdit(product)">
                                                Edit
                                            </v-btn>
                                            <v-btn color="error" depressed small @click="getDelete(product)">
                                                Delete
                                            </v-btn>
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </template>

                </v-container>
            </v-main>
        </v-app>
    </div>

      <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    new Vue({
    el: "#app",
    vuetify: new Vuetify(),
    data: {
        products: "",
        productName: "",
        nama_barang: "",
        productPrice: "",
        dialogAdd: false,
        dialogEdit: false,
        dialogDelete: false,
        productIdEdit: "",
        productNameEdit: "",
        productPriceEdit: "",
        productIdDelete: "",
        productNameDelete: "",
    },
    created: function () {
        this.getProducts();
    },
    methods: {
        // Get Product
        getProducts: function () {
            axios
                .get("api/barang")
                .then((res) => {
                    this.products = res.data;
                })
                .catch((err) => {
                    // handle error
                    console.log(err);
                });
        },

        // Create New product
        saveProduct: function () {
            axios
                .post("http://localhost:8080/products", {
                    product_name: this.productName,
                    product_price: this.productPrice,
                })
                .then((res) => {
                    // handle success
                    this.getProducts();
                    this.productName = "";
                    this.productPrice = "";
                    this.dialogAdd = false;
                })
                .catch((err) => {
                    // handle error
                    console.log(err);
                });
        },

        // Get Edit and Show data to Modal
        getEdit: function (product) {
            this.dialogEdit = true;
            this.productIdEdit = product.product_id;
            this.productNameEdit = product.product_name;
            this.productPriceEdit = product.product_price;
        },

        // Get Delete and Show Confirm Modal
        getDelete: function (product) {
            this.dialogDelete = true;
            this.productIdDelete = product.product_id;
            this.productNameDelete = product.product_name;
        },

        // Update Product
        updateProduct: function () {
            axios
                .put(`http://localhost:8080/products/${this.productIdEdit}`, {
                    product_name: this.productNameEdit,
                    product_price: this.productPriceEdit,
                })
                .then((res) => {
                    // handle success
                    this.getProducts();
                    this.dialogEdit = false;
                })
                .catch((err) => {
                    // handle error
                    console.log(err);
                });
        },

        // Delete Product
        deleteProduct: function () {
            axios
                .delete(
                    `http://localhost:8080/products/${this.productIdDelete}`
                )
                .then((res) => {
                    // handle success
                    this.getProducts();
                    this.dialogDelete = false;
                })
                .catch((err) => {
                    // handle error
                    console.log(err);
                });
        },
    },
});
</script>


</body>

</html>
