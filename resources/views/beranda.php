<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

    <div id="vue-app" class ="container mt-4">
        <div class="alert alert-light mb-2  text-center" role="alert">
            <h4>
                <b>
                    Selamat Datang {{user.name ? user.name : 'Anonim'}}
                    <hr>
                </b>
            </h4>
            </div>
    <div class="">
       <h4>Data Barang :</h4>
    </div>

       <table class="table table-hover text-center">
           <a href="#input"type="button"
        class="btn btn-success text-light mt-1 mb-1"
        @click="deleteData(barang)">Tambah Data</a>
  <thead>
    <tr>
      <th scope="col">NO</th>
      <th scope="col">Nama Barang</th>
      <th scope="col">Stok</th>
      <th scope="col">Harga</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
     <tr v-for="(barang, index) in barangs" :key="barang.id">
       <td>{{ index + 1 }}</td>
      <td>{{ barang.nama_barang }}</td>
      <td>{{ barang.stok }}</td>
     <td>Rp.{{ barang.harga }}</td>
    <td>
        <!-- <button
        type="button"
        class="btn btn-primary text-light"
        @click="getEdit(barang)"
        >
    </button> -->
    <a href="#input"
     type="button"
        class="btn btn-primary text-light"
        @click="getEdit(barang)">Edit
    </a>
    <a href="#"
     type="button"
        class="btn btn-danger text-light"
        @click="deleteData(barang)">Hapus
    </a>
    </td>
    </tr>

  </tbody>
</table>
            <div id="input">
                <hr>
                <h4 v-show="editBarang">Edit Data</h4>
                <h4 v-show="!editBarang">Input Data</h4>
                <hr>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" v-model="namaBarangAdd" placeholder="Nama Barang">
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" class="form-control" v-model="hargaAdd" placeholder="Harga Barang">

                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="text" class="form-control" v-model="stokAdd" placeholder="Stok Barang">

                </div>
                <button class="btn btn-primary" @click="addData" v-show="!editBarang">Simpan</button>
                <button class="btn btn-primary" @click="editData" v-show="editBarang">Simpan</button>
                <!-- </form> -->
            </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>
<script>
     new Vue({
        el: '#vue-app',
        data: {
           barangs : '',
           namaBarangAdd : '',
           hargaAdd : '',
           stokAdd : '',
           id: '',
           editBarang: false,
           deleteBarang : false,
           nama_barang : '',
           harga_barang : '',
           stok_barang : '',
           user: false
        },
    //     created: function () {
    //     this.dataBarang();
    // },
       methods: {

        dataBarang ()  {
            axios.get('api/barang')
                .then(res => {
                    this.barangs = res.data;

                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },
        editData(){
            axios
                .put("api/barang", {
                    nama_barang: this.namaBarangAdd,
                    stok: this.stokAdd,
                    harga : this.hargaAdd,
                    id : this.id,
                })
                .then((res) => {
                    // handle success
                    this.dataBarang();
                    this.namaBarangAdd = '';
                    this.hargaAdd = '';
                    this.stokAdd = '';
                    this.id = '';
                    this.editBarang = false;
                })
                .catch((err) => {
                    // handle error
                    console.log(err);
                });
        },
        getEdit(data) {
            this.editBarang = true;
            this.id = data.id;
            this.namaBarangAdd = data.nama_barang;
            this.hargaAdd = data.harga;
            this.stokAdd = data.stok;

        },
        deleteData(data){
             this.id = data.id;
             axios
                .delete(
                    `api/barang/${this.id}`
                )
                .then((res) => {
                    // handle success
                    this.dataBarang();
                })
                .catch((err) => {
                    // handle error
                    console.log(err);
                });
        },
        addData(data){
            axios
                .post("api/barang", {
                    nama_barang: this.namaBarangAdd,
                    harga: this.hargaAdd,
                    stok: this.stokAdd,
                })
                .then((res) => {
                    // handle success
                    this.dataBarang();
                    // alert("Tambah data Berhasil");
                    // Swal.fire(
                    // 'Good job!',
                    // 'You clicked the button!',
                    // 'success'
                    // )
                    this.namaBarangAdd = '';
                    this.hargaAdd = '';
                    this.stokAdd = '';
                })
                .catch((err) => {
                    // handle error
                    console.log(err);
                });
        },


    },
        mounted () {
             this.user = JSON.parse(localStorage.getItem("user"));
            axios.get('api/barang')
                .then(res => {
                    this.barangs = res.data;

                })
                .catch(err => {
                    // handle error
                    console.log(err);
                })
        },


    });
</script>

</html>
