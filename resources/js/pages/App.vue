<template>
    <div class="container">
        <div
            style="display: flex; justify-content: center; align-items: center"
        >
            <form
                class="form-inline"
                style="
                    margin-top: 100px;
                    margin-bottom: 0px;
                    text-align: center;
                    padding-right: 5px;
                "
                ref="form1"
                @submit.prevent="fetchProducts"
            >
                <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only"
                        >Search Product</label
                    >
                </div>
                <div class="form-group mb-2">
                    <input
                        type="text"
                        class="form-control"
                        style="display: inline; width: inherit !important"
                        id="sku"
                        placeholder="sku"
                        v-model="form1.sku"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    Search
                </button>
            </form>

            <form
                class="form-inline"
                style="
                    margin-top: 100px;
                    margin-bottom: 0px;
                    text-align: center;
                    padding-left: 5px;
                "
                ref="form2"
                @submit.prevent="fetchAccounts"
            >
                <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only"
                        >Search Account</label
                    >
                </div>
                <div class="form-group mb-2">
                    <input
                        type="text"
                        class="form-control"
                        style="display: inline; width: inherit !important"
                        id="account"
                        placeholder="account"
                        v-model="form2.account"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary mb-2">
                    Search
                </button>
            </form>
        </div>

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
                    <p class="card-text" style="font-weight: bold">
                        {{ product.price }}
                    </p>
                </div>
            </div>
        </div>

        <div
            style="display: grid; justify-content: center; align-items: center"
        >
            <div
                class="card border-secondary mb-3"
                style="max-width: 18rem; margin-top: 30px; text-align: center"
                v-for="account in accounts"
                :key="account.id"
            >
                <div class="card-header">{{ account.sku }}</div>
                <div class="card-body text-secondary">
                    <p class="card-text">
                        {{ account.account }}
                    </p>
                     <p class="card-text" style="font-weight: bold">
                        {{ account.price }}
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
            form1: {
                sku: "",
            },
            form2: {
                account: "",
            },
            products: null,
            accounts: null,
            errors: null,
        };
    },

    methods: {
        fetchProducts() {
            let uri = "http://127.0.0.1:8000/api/prices/sku/" + this.form1.sku;
            axios
                .get(uri)
                .then((response) => {
                    this.products = response.data;
                    this.errors = false;
                    this.form1.sku = '';
                    this.accounts = [];
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.products = null;
                        this.errors = error.response.data.message;
                    }
                });
        },
        fetchAccounts() {
            let uri = "http://127.0.0.1:8000/api/prices/account/" + this.form2.account;
            axios
                .get(uri)
                .then((response) => {
                    this.accounts = response.data;
                    this.errors = false;
                    this.form2.account = '';
                    this.products = [];
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.accounts = null;
                        this.errors = error.response.data.message;
                    }
                });
        },
    },
};
</script>
