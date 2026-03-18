/**
 * Cart & Menu Logic - Cafeteria System
 * FIXED: Standardized functions, dynamic UI updates.
 * FIXED: Added sorting functionality for product grid.
 */

const Cart = {
    items: JSON.parse(localStorage.getItem('user_cart')) || [],
    originalProducts: [], // Store for sorting

    init() {
        this.updateTotal();
        this.render();
        this.setupEvents();
        this.captureInitialState();
        console.log("Cart & Sorting System Ready");
    },

    captureInitialState() {
        const grid = document.getElementById('product-grid');
        if (!grid) return;
        this.originalProducts = Array.from(grid.querySelectorAll('.col')).map(card => ({
            element: card,
            name: card.querySelector('h5').innerText,
            price: parseFloat(card.querySelector('.badge').innerText.replace('$', ''))
        }));
    },

    // --- CART ACTIONS ---
    addToCart(product) {
        const index = this.items.findIndex(p => p.id === product.id);
        if (index > -1) {
            this.items[index].quantity += 1;
        } else {
            this.items.push({ ...product, quantity: 1 });
        }
        this.save();
        this.showFeedback(`${product.name} added to order!`);
    },

    increaseQuantity(id) {
        const item = this.items.find(p => p.id === id);
        if (item) { item.quantity += 1; this.save(); }
    },

    decreaseQuantity(id) {
        const index = this.items.findIndex(p => p.id === id);
        if (index > -1) {
            this.items[index].quantity -= 1;
            if (this.items[index].quantity <= 0) this.items.splice(index, 1);
            this.save();
        }
    },

    removeItem(id) {
        this.items = this.items.filter(p => p.id !== id);
        this.save();
    },

    // --- UI UPDATES ---
    updateTotal() {
        const subtotal = this.items.reduce((sum, p) => sum + (p.price * p.quantity), 0);
        const formattedTotal = subtotal.toFixed(2);
        
        document.querySelectorAll('#cart-total').forEach(el => el.innerText = `$${formattedTotal}`);
        document.querySelectorAll('#cart-count').forEach(el => el.innerText = `${this.items.length} Items`);

        const btnCheckout = document.getElementById('btn-checkout');
        if (btnCheckout) btnCheckout.disabled = this.items.length === 0;
    },

    save() {
        localStorage.setItem('user_cart', JSON.stringify(this.items));
        this.updateTotal();
        this.render();
    },

    render() {
        this.renderSidebar();
        this.renderCheckout();
    },

    renderSidebar() {
        const container = document.getElementById('cart-items-container');
        if (!container) return;

        if (this.items.length === 0) {
            container.innerHTML = '<div class="text-center py-5 text-muted small"><i class="bi bi-cart3 fs-2 d-block mb-2 opacity-25"></i>Empty</div>';
            return;
        }

        container.innerHTML = this.items.map(item => `
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="uploads/products/${item.image || 'default.png'}" class="rounded-3 shadow-sm" style="width: 35px; height: 35px; object-fit: cover;" onerror="this.src='https://placehold.co/40?text=Food'">
                    <div>
                        <div class="fw-bold small text-truncate" style="max-width: 80px;">${item.name}</div>
                        <div class="text-warning fw-bold small">$${(item.price * item.quantity).toFixed(2)}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 bg-light rounded-pill px-2 py-1">
                    <button class="btn btn-sm p-0 m-0 border-0 btn-qty-down" data-id="${item.id}"><i class="bi bi-dash"></i></button>
                    <span class="small fw-black mx-1">${item.quantity}</span>
                    <button class="btn btn-sm p-0 m-0 border-0 btn-qty-up" data-id="${item.id}"><i class="bi bi-plus text-warning"></i></button>
                </div>
            </div>
        `).join('');
    },

    renderCheckout() {
        const container = document.getElementById('checkout-items-list');
        if (!container) return;

        if (this.items.length === 0) {
            container.innerHTML = '<div class="text-center py-5 text-muted">Empty Cart</div>';
            return;
        }

        container.innerHTML = this.items.map(item => `
            <div class="cart-item d-flex align-items-center justify-content-between py-4 border-bottom px-3 mb-2">
                <div class="d-flex align-items-center gap-4">
                    <img src="uploads/products/${item.image || 'default.png'}" class="rounded-4 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;" onerror="this.src='https://placehold.co/60?text=Food'">
                    <div><h6 class="fw-bold mb-1">${item.name}</h6><p class="text-muted small mb-0">$${item.price.toFixed(2)}</p></div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="input-group input-group-sm rounded-pill border py-1 px-2" style="width: 100px;">
                        <button class="btn btn-sm btn-link text-dark p-0 btn-qty-down" data-id="${item.id}"><i class="bi bi-dash"></i></button>
                        <input type="text" class="form-control bg-transparent border-0 text-center fw-bold" value="${item.quantity}" readonly>
                        <button class="btn btn-sm btn-link text-warning p-0 btn-qty-up" data-id="${item.id}"><i class="bi bi-plus"></i></button>
                    </div>
                    <div class="fw-bold fs-5" style="min-width: 80px;">$${(item.price * item.quantity).toFixed(2)}</div>
                    <button class="btn btn-link text-danger p-0 btn-remove" data-id="${item.id}"><i class="bi bi-trash-fill fs-5"></i></button>
                </div>
            </div>
        `).join('');
    },

    // --- SORTING ACTION ---
    sortGrid(type) {
        const grid = document.getElementById('product-grid');
        if (!grid) return;

        const sorted = [...this.originalProducts].sort((a, b) => {
            if (type === 'price_low') return a.price - b.price;
            if (type === 'price_high') return b.price - a.price;
            if (type === 'name') return a.name.localeCompare(b.name);
            return 0; // Default
        });

        grid.innerHTML = '';
        sorted.forEach(p => grid.appendChild(p.element));
    },

    setupEvents() {
        document.addEventListener('click', (e) => {
            const el = e.target.closest('button');
            if (!el) return;
            const id = parseInt(el.dataset.id);

            if (el.classList.contains('btn-add-to-cart')) {
                this.addToCart({ id, name: el.dataset.name, price: parseFloat(el.dataset.price), image: el.dataset.image });
            } else if (el.classList.contains('btn-qty-up')) this.increaseQuantity(id);
            else if (el.classList.contains('btn-qty-down')) this.decreaseQuantity(id);
            else if (el.classList.contains('btn-remove')) this.removeItem(id);
        });

        // Sorting trigger
        const sorter = document.getElementById('sort_products');
        if (sorter) sorter.addEventListener('change', (e) => this.sortGrid(e.target.value));

        // Checkout Form
        const form = document.getElementById('checkout-form');
        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (this.items.length === 0) return alert("Cart is empty!");

                const btn = form.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';

                const orderData = {
                    user_id: window.userId,
                    room_no: form.querySelector('[name="room_no"]').value,
                    notes: form.querySelector('[name="notes"]').value,
                    items: this.items
                };

                try {
                    const response = await fetch('index.php?page=confirm-order', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(orderData)
                    });

                    const result = await response.json();
                    if (result.success) {
                        this.items = [];
                        this.save();
                        window.location.href = 'index.php?page=orders';
                    } else {
                        alert("Order failed: " + result.message);
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                } catch (error) {
                    console.error("Order Error:", error);
                    alert("A connection error occurred. Please try again.");
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        }
    },

    showFeedback(msg) {
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 start-50 translate-middle-x mb-5 bg-dark text-white px-4 py-2 rounded-pill shadow-lg z-3';
        toast.innerHTML = `<i class="bi bi-check-circle-fill text-warning me-2"></i> ${msg}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2500);
    }
};

document.addEventListener('DOMContentLoaded', () => Cart.init());
