document.addEventListener('DOMContentLoaded', () => {
    // Add to Cart with AJAX
    const cartForms = document.querySelectorAll('form[action="/ajr_fashion/add_to_cart.php"]');
    cartForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            form.classList.add('loading');
            const formData = new FormData(form);
            await fetch('/ajr_fashion/add_to_cart.php', {
                method: 'POST',
                body: formData
            });
            form.classList.remove('loading');
            alert('Item added to cart!');
        });
    });

    // Filter and Search
    const categoryFilter = document.getElementById('categoryFilter');
    const searchInput = document.getElementById('searchInput');
    const productGrid = document.getElementById('productGrid');

    if (categoryFilter && searchInput && productGrid) {
        categoryFilter.addEventListener('change', filterProducts);
        searchInput.addEventListener('input', filterProducts);

        async function filterProducts() {
            const category = categoryFilter.value;
            const search = searchInput.value.toLowerCase();
            const response = await fetch(`/ajr_fashion/api/products.php?category=${category}&search=${search}`);
            const products = await response.json();
            productGrid.innerHTML = products.map(product => `
                <div class="product-card bg-white rounded-lg shadow">
                    <img src="${product.image_url}" alt="${product.name}" class="w-full h-64 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold">${product.name}</h3>
                        <p class="text-gray-600">$${parseFloat(product.price).toFixed(2)}</p>
                        <a href="/ajr_fashion/product.php?id=${product.id}" class="mt-4 inline-block btn bg-pink-600 text-white px-4 py-2 rounded">View Details</a>
                    </div>
                </div>
            `).join('');
        }
    }
});