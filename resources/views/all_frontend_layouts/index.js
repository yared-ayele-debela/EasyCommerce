function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cartCount').innerText = data.count;
        })
        .catch(error => console.error('Error fetching cart count:', error));
}

// Call the function on page load
document.addEventListener('DOMContentLoaded', updateCartCount);
