<template>
    <div class="container">
        <form
            class="form-inline"
            style="margin-top: 100px; margin-bottom: 0px; text-align: center"
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
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary mb-2">Search</button>
        </form>

        <div
            style="display: grid; justify-content: center; align-items: center"
        >
            <div
                class="card border-secondary mb-3"
                style="max-width: 18rem; margin-top: 30px; text-align: center"
                v-for="product in products"
                :key="product.id"
            >
                <div class="card-header">{{ product.sku }}</div>
                <div class="card-body text-secondary">
                    <p class="card-text">
                        {{ product.price }}
                    </p>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center" v-if="errors">
            <p>{{ errors }}</p>
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
            products: null,
            errors: null,
        };
    },

    methods: {
        fetchProducts() {
            let uri = "http://127.0.0.1:8000/api/prices/" + this.form.sku;
            axios
                .get(uri)
                .then((response) => {
                    this.products = response.data;
                    this.errors = false;
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.products = null;
                        this.errors = error.response.data.message;
                    }
                });
        },
    },
};
</script>