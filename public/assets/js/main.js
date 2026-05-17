






































function addToCart(productId) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.success) {
                document.getElementById('cart-count').innerText = response.cart_count;
                alert("Product added to cart!");
            }
        }
           };
    xhttp.open("POST", "../api/cart.php?action=add", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("product_id=" + productId);
}
