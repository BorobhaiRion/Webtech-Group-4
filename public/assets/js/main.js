function searchProducts() {
    let q = document.getElementById('search-input').value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            renderProducts(JSON.parse(this.responseText));
        }
    };
    xhttp.open("GET", "../api/products.php?action=search&q=" + q, true);
    xhttp.send();
}

function filterCategory(catId) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            renderProducts(JSON.parse(this.responseText));
        }
    };
    xhttp.open("GET", "../api/products.php?action=filter&category_id=" + catId, true);
    xhttp.send();
}

function renderProducts(products) {
    let container = document.getElementById('product-list');
    container.innerHTML = '';
    products.forEach(product => {
        container.innerHTML += `
            <div class="product-card">
                <img src="../public/uploads/products/${product.primary_image_path || 'default.png'}" alt="${product.name}">
                <h4>${product.name}</h4>
                <p class="price">$${product.price}</p>
                <a href="product_detail.php?id=${product.id}" class="btn">View Details</a>
                <button onclick="addToCart(${product.id})" class="btn secondary">Add to Cart</button>
            </div>
        `;
    });
}