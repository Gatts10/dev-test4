<template>
    <div class="container">
        <form class="form-inline" style="margin-top: 100px; text-align: center">
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
                />
            </div>
            <button type="submit" class="btn btn-primary mb-2">Search</button>
        </form>

        <div v-for="price in prices" :key="price.id">
            {{ price.sku }}
            {{ price.price }}
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            prices: [],
        };
    },

    created: function () {
        this.fetchPrices();
    },

    methods: {
        fetchPrices() {
            let uri = "/prices";
            axios.get(uri).then((response) => {
                this.prices = response.data;
            });
        },
    },
};
</script>
