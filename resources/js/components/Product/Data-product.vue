<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Product</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success" @click="showModal" >
                                Tambah Product
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in products" :key="item.id">
                                    <td>{{ item.nama }}</td>
                                    <td>{{ item.keterangan }}</td>
                                    <td>{{ item.harga }}</td>
                                    <td>
                                        <a href="#" @click="showModalEdit(item)" >
                                            <i class="fas fa-edit blue"></i>
                                        </a>
                                        |<a href="#" @click="deleteData(item.id)">
                                            <i class="fas fa-trash-alt red"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalmuncul" tabindex="-1" role="dialog" aria-labelledby="modalmuncul1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" v-show="!statusmodal">
                            Tambah Product
                        </h5>
                        <h5 class="modal-title" id="exampleModalLongTitle" v-show="statusmodal">
                            Ubah Product
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent=" statusmodal ? ubahData() : simpanData()">
                        <div class="modal-body">

                            <div class="form-group">
                                <input type="text" v-model="form.nama" class="form-control" placeholder="Nama Product"
                                :class="{
                                    'is-invalid': form.errors.has('nama')
                                }"/>
                                <has-error :form="form" field="nama"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <input type="text" v-model="form.keterangan" class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('keterangan')
                                }"
                                placeholder="keterangan"/>
                                <has-error :form="form" field="keterangan"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <input type="number" v-model="form.harga" class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('harga')
                                }"
                                placeholder="harga"/>
                                <has-error :form="form" field="harga"
                                ></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" :disabled="disabled" v-show="!statusmodal">
                                <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                Simpan
                            </button>
                            <button type="submit" class="btn btn-success" :disabled="disabled" v-show="statusmodal">
                                <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                Ubah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Modal -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                disabled: false,
                products: {},
                statusmodal: false,
                form: new Form({
                    id: "",
                    nama: "",
                    keterangan: "",
                    harga: ""
                })
            };
        },
        methods: {
            showModal() {
                this.statusmodal = false;
                this.form.reset();
                $("#modalmuncul").modal("show");
            },
            showModalEdit(item) {
                this.statusmodal = true;
                this.form.reset();
                $("#modalmuncul").modal("show");
                this.form.fill(item);
            },
            loadData() {
                this.$Progress.start();
                axios.get("api/product").then(({ data }) => (this.products = data));
                this.$Progress.finish();
            },
            simpanData() {
                this.$Progress.start();
                this.loading = true;
                this.disabled = true;
                this.form
                .post("api/product")
                .then(() => {
                    Fire.$emit("refreshData");
                    $("#modalmuncul").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Data Berhasil Tersimpan"
                    });
                    this.$Progress.finish();
                    this.loading = false;
                    this.disabled = false;
                })
                .catch(() => {
                    this.$Progress.fail();
                    this.loading = false;
                    this.disabled = false;
                });
            },
            ubahData() {
                this.$Progress.start();
                this.loading = true;
                this.disabled = true;
                this.form
                .put("api/product/" + this.form.id)
                .then(() => {
                    Fire.$emit("refreshData");
                    $("#modalmuncul").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Data Berhasil Terupdate"
                    });
                    this.$Progress.finish();
                    this.loading = false;
                    this.disabled = false;
                })
                .catch(() => {
                    this.$Progress.fail();
                    this.loading = false;
                    this.disabled = false;
                });
            },
            deleteData(id) {
                Swal.fire({
                    title: "Anda Yakin Ingin Menghapus Data Ini ?",
                    text: "Klik Batal Untuk Membatalkan Penghapusan",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus"
                }).then(result => {
                    if (result.value) {
                        this.form
                        .delete("api/product/" + id)
                        .then(() => {
                            Swal.fire(
                                "Terhapus",
                                "Data Anda Sudah Tehapus",
                                "success"
                                );
                            Fire.$emit("refreshData");
                        })
                        .catch(() => {
                            Swal.fire(
                                "Gagal",
                                "Data Gagal Terhapus",
                                "warning"
                                );
                        });
                    }
                });
            }
        },
        created() {
            this.loadData();
            Fire.$on("refreshData", () => {
                this.loadData();
            });
        }
    };
</script>
