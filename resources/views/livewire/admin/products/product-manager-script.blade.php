@once
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productManager', () => ({
                createProductOpen: @js($errors->any()),

                editProductOpen: false,

                stockAdjustOpen: false,

                editingProduct: null,

                stockAdjustDirection: 'receive',

                stockAdjustQuantity: 0,

                init() {
                    this.$watch('createProductOpen', (open) => {
                        if (open) {
                            this.$nextTick(() => {
                                document
                                    .getElementById('create_product_name')
                                    ?.focus();
                            });
                        }
                    });
                },

                openCreateProduct() {
                    this.editProductOpen = false;
                    this.stockAdjustOpen = false;
                    this.createProductOpen = true;
                },

                closeCreateProduct() {
                    this.createProductOpen = false;
                },

                openEditProduct(product) {
                    this.createProductOpen = false;
                    this.stockAdjustOpen = false;
                    this.editingProduct = product;
                    this.editProductOpen = true;
                },

                closeEditProduct() {
                    this.editProductOpen = false;
                    this.editingProduct = null;
                },

                openStockAdjust(product) {
                    this.createProductOpen = false;
                    this.editProductOpen = false;
                    this.editingProduct = product;
                    this.stockAdjustDirection = 'receive';
                    this.stockAdjustQuantity = 0;
                    this.stockAdjustOpen = true;
                },

                closeStockAdjust() {
                    this.stockAdjustOpen = false;
                    this.editingProduct = null;
                },

                closeProducts() {
                    this.closeCreateProduct();
                    this.closeEditProduct();
                    this.closeStockAdjust();
                },
            }));
        });
    </script>
@endonce