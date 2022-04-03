<template>
    <div>
        <div class="col-md-6">
            <h1>Contact</h1>
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    class="form-control"
                    placeholder="Enter Name"
                    v-model="item.name"
                />
            </div>
            <div class="form-group">
                <label for="tel">Tel</label>
                <input
                    type="text"
                    id="tel"
                    class="form-control"
                    placeholder="Enter tel"
                    v-model="item.tel"
                />
            </div>
            <div class="form-group">
                <label for="tel">Image</label>
                <input type="file" @change="selectFile" />
            </div>
            <button class="btn btn-success btn-block" @click="saveTel">
                {{ isEditing ? "Update" : "Save" }}
            </button>
        </div>
        <div class="col-md-12" v-if="lists.length > 0">
            <h2 class="text-center">Telephone Number</h2>
            <ul class="list-group">
                <li
                    class="list-group-item"
                    v-for="item in lists"
                    :key="item.id"
                >
                    {{ item.name }} - {{ item.tel }}
                   <img :src="item.image" style="heigh:10px"/>
                    <span class="float-right">
                        
                        <button
                            class="btn btn-danger btn btn-sm mr-2"
                            @click="deleteTel(item.id)"
                        >
                            Delete
                        </button>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    name: "directory",
    data() {
        return {
            lists: [],
            item: {
                name: "",
                tel: "",
                image: null,
            },
            photo: null,
            temp_id: null,
            isEditing: false,
        };
    },
    mounted() {
        this.fetchTel();
    },
    methods: {
        selectFile(event) {
            this.item.image = event.target.files[0];
        },
        fetchTel() {
            axios.get("/api/tel").then((res) => (this.lists = res.data));
        },
        saveTel() {
            let method = axios.post;
            let url = "api/tel";

            if (this.isEditing) {
                method = axios.put;
                url = `api/tel/${this.temp_id}`;
            }
            try {

                let formData = new FormData();
                formData.append("image", this.item.image);
                formData.append("name", this.item.name);
                formData.append("tel", this.item.tel);
                method(url, formData, {
                    headers: {
                        "Content-Type":
                            "multipart/form-data; charset=utf-8; boundary=" +
                            Math.random().toString().substr(2),
                    },
                }).then((res) => {
                    this.fetchTel();
                    this.item = {
                        name: "",
                        tel: "",
                        image:"",
                    };
                    this.temp_id = null;
                    this.isEditing = false;
                });
            } catch (error) {}
        },
        deleteTel(id) {
            try {
                axios.delete(`/api/tel/${id}`).then((res) => this.fetchTel());
            } catch (error) {}
        },
        editTel(tel) {
            this.item = {
                name: tel.name,
                tel: tel.tel,
            };
            this.temp_id = tel.id;
            this.isEditing = true;
        },
    },
};
</script>
