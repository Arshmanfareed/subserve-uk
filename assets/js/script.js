$(document).ready(function() {
    // Function to update products based on selected brands
    function updateProducts() {
        var selectedBrands = [];
        $('input[name="brands[]"]:checked').each(function() {
            selectedBrands.push($(this).val());
        });

        // AJAX request to filter products
        $.ajax({
            type: 'POST',
            url: 'filter_products.php', // Create this PHP file
            data: {
                category_id: <?php echo $Category_ID; ?>,
                brands: selectedBrands
            },
            success: function(response) {
                $('#filtered-products-container').html(response);
            }
        });
    }

    // Event handler for brand checkboxes
    $('input[name="brands[]"]').on('change', function() {
        updateProducts();
    });

    // Initial update based on default selected brands
    updateProducts();
});