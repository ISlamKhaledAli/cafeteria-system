/**
 * Cafeteria System - Cart Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    // State
    let cart = JSON.parse(localStorage.getItem('cafeteria_cart')) || [];

    // DOM Elements
    const cartToggle = document.getElementById('cart-toggle');
    const closeCart = document.getElementById('close-cart');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartOverlay = document.getElementById('cart-overlay');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    const cartCountBadge = document.getElementById('cart-count-badge');

    // --- Core Functions ---

    function saveCart() {
        localStorage.setItem('cafeteria_cart', JSON.stringify(cart));
        renderCart();
    }

    function addToCart(productId, name, price) {
        const existingItem = cart.find(item => item.id === productId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: name,
                price: parseFloat(price),
                quantity: 1
            });
        }
        saveCart();
        openCartSidebar();
    }

    function increaseQuantity(productId) {
        const item = cart.find(item => item.id === productId);
        if (item) {
            item.quantity += 1;
            saveCart();
        }
    }

    function decreaseQuantity(productId) {
        const item = cart.find(item => item.id === productId);
        if (item) {
            item.quantity -= 1;
            if (item.quantity <= 0) {
                removeItem(productId);
            } else {
                saveCart();
            }
        }
    }

    function removeItem(productId) {
        cart = cart.filter(item => item.id !== productId);
        saveCart();
    }

    function calculateTotal() {
        return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    // --- UI Rendering ---

    function renderCart() {
        if (!cartItemsContainer) return;

        if (cart.length === 0) {
            const emptyHtml = `
                <div class="text-center text-muted py-5 bg-white rounded-3 shadow-sm w-100">
                    <i class="bi bi-cart fs-1 d-block mb-3"></i>
                    Your cart is empty
                </div>
            `;
            cartItemsContainer.innerHTML = emptyHtml;
            if (cartTotalElement) cartTotalElement.textContent = '$0.00';
            const cartSubtotalElement = document.getElementById('cart-subtotal');
            if (cartSubtotalElement) cartSubtotalElement.textContent = '$0.00';
            if (cartCountBadge) cartCountBadge.textContent = '0';
            return;
        }

        let html = '';
        let totalCount = 0;

        // Check if we are on the Cart Page or using the Sidebar
        const isCartPage = window.location.pathname.includes('cart.php');

        cart.forEach(item => {
            totalCount += item.quantity;
            if (isCartPage) {
                // Large Page Layout (Matches components/cart-item.php but in JS)
                html += `
                    <div class="card mb-3 border-0 shadow-sm cart-item-card w-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="cart-item-info">
                                    <h6 class="fw-bold mb-1">${item.name}</h6>
                                    <span class="text-muted fw-bold">$${item.price.toFixed(2)}</span>
                                </div>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="quantity-controls d-flex align-items-center bg-light rounded-pill px-2 py-1">
                                        <button class="btn btn-sm p-0 px-2 btn-decrease border-0" data-id="${item.id}">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="fw-bold mx-2" style="min-width: 20px; text-align: center;">${item.quantity}</span>
                                        <button class="btn btn-sm p-0 px-2 btn-increase border-0" data-id="${item.id}">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    <div class="text-end" style="min-width: 80px;">
                                        <span class="fw-bold text-dark">$${(item.price * item.quantity).toFixed(2)}</span>
                                    </div>
                                    <button class="btn btn-link text-danger p-0 btn-remove" data-id="${item.id}">
                                        <i class="bi bi-trash fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Sidebar Layout
                html += `
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <h6 class="fw-bold mb-1">${item.name}</h6>
                            <span class="text-muted small">$${item.price.toFixed(2)}</span>
                        </div>
                        <div class="d-flex flex-column align-items-end gap-2">
                            <div class="quantity-controls">
                                <button class="btn btn-sm p-0 px-2 btn-decrease" data-id="${item.id}">-</button>
                                <span class="fw-bold mx-1">${item.quantity}</span>
                                <button class="btn btn-sm p-0 px-2 btn-increase" data-id="${item.id}">+</button>
                            </div>
                            <button class="btn btn-link text-danger btn-sm p-0 btn-remove" data-id="${item.id}">Remove</button>
                        </div>
                    </div>
                `;
            }
        });

        cartItemsContainer.innerHTML = html;
        const total = calculateTotal().toFixed(2);
        if (cartTotalElement) cartTotalElement.textContent = `$${total}`;
        
        const cartSubtotalElement = document.getElementById('cart-subtotal');
        if (cartSubtotalElement) cartSubtotalElement.textContent = `$${total}`;
        
        if (cartCountBadge) cartCountBadge.textContent = totalCount;

        // Re-attach event listeners for dynamic buttons
        attachItemEventListeners();
    }

    function attachItemEventListeners() {
        document.querySelectorAll('.btn-increase').forEach(btn => {
            btn.addEventListener('click', () => increaseQuantity(parseInt(btn.dataset.id)));
        });
        document.querySelectorAll('.btn-decrease').forEach(btn => {
            btn.addEventListener('click', () => decreaseQuantity(parseInt(btn.dataset.id)));
        });
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', () => removeItem(parseInt(btn.dataset.id)));
        });
    }

    // --- Sidebar Controls ---

    function openCartSidebar() {
        cartSidebar.classList.add('active');
        cartOverlay.classList.add('show');
    }

    function closeCartSidebar() {
        cartSidebar.classList.remove('active');
        cartOverlay.classList.remove('show');
    }

    // --- Global Event Listeners ---

    // Listen for Add to Cart buttons
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.add-to-cart-btn');
        if (btn) {
            const id = parseInt(btn.dataset.id);
            const name = btn.dataset.name;
            const price = btn.dataset.price;
            addToCart(id, name, price);
        }
    });

    if (cartToggle) cartToggle.addEventListener('click', openCartSidebar);
    if (closeCart) closeCart.addEventListener('click', closeCartSidebar);
    if (cartOverlay) cartOverlay.addEventListener('click', closeCartSidebar);

    // Initial Render
    renderCart();
});
