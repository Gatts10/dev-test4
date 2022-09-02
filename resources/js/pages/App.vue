<template>
    <div class="container">
        <form
            class="form-inline"
            style="margin-top: 100px; text-align: center"
            ref="form"
            @submit.prevent="fetchProducts"
        >
            <div class="form-group mb-2">
                <label for="staticEmail2" class="sr-only">Search Product</label>
            </div>
            <div class="form-group mb-2">
                <input
                    type="text"
                    class="form-control"
                    style="display: inline; width: inherit !important"
                    id="sku"
                    placeholder="sku"
                    v-model="form.sku"
                />
            </div>
            <button type="submit" class="btn btn-primary mb-2">Search</button>
        </form>

        <div v-for="product in products" :key="product.id">
            {{ product.sku }}
            {{ product.price }}
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                sku: "",
            },
            products: [],
        };
    },

    created: function () {
        this.fetchProducts();
    },

    methods: {
        fetchProducts() {
            let uri = 'http://127.0.0.1:8000/api/prices/' + this.form.sku;
            axios.get(uri).then((response) => {
                this.products = response.data;
            });
        },
    },
};
</script>
