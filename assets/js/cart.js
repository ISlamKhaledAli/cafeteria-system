/**
 * Cart & Menu Logic - Cafeteria System
 * UPDATED: Added Nav Badge support and Room Selection sync.
 */

const Cart = {
  items: JSON.parse(localStorage.getItem("user_cart")) || [],

  init() {
    this.updateTotal();
    this.render();
    this.setupEvents();
    this.syncRoomSelection();
    console.log("Cart System Ready (EGP)");
  },

  addToCart(product) {
    const index = this.items.findIndex((p) => p.id === product.id);
    if (index > -1) {
      this.items[index].quantity += 1;
    } else {
      this.items.push({ ...product, quantity: 1 });
    }
    this.save();
    this.showFeedback(`${product.name} added to order!`);
  },

  increaseQuantity(id) {
    const item = this.items.find((p) => p.id === id);
    if (item) {
      item.quantity += 1;
      this.save();
    }
  },

  decreaseQuantity(id) {
    const index = this.items.findIndex((p) => p.id === id);
    if (index > -1) {
      this.items[index].quantity -= 1;
      if (this.items[index].quantity <= 0) this.items.splice(index, 1);
      this.save();
    }
  },

  removeItem(id) {
    this.items = this.items.filter((p) => p.id !== id);
    this.save();
  },

  updateTotal() {
    const subtotal = this.items.reduce(
      (sum, p) => sum + p.price * p.quantity,
      0,
    );
    const count = this.items.reduce((sum, p) => sum + p.quantity, 0);
    const formattedTotal = subtotal.toFixed(2);

    document
      .querySelectorAll("#cart-total")
      .forEach((el) => (el.innerText = `${formattedTotal} EGP`));
    document
      .querySelectorAll("#cart-count")
      .forEach((el) => (el.innerText = `${this.items.length} Items`));

    const badge = document.getElementById("cart-badge");
    if (badge) {
      badge.innerText = count;
      badge.style.display = count > 0 ? "block" : "none";
      setTimeout(() => (badge.style.transform = "scale(1)"), 200);
      badge.style.transition = "transform 0.2s ease-out";
    }

    const btnCheckout = document.getElementById("btn-checkout");
    if (btnCheckout) btnCheckout.disabled = this.items.length === 0;
  },

  save() {
    localStorage.setItem("user_cart", JSON.stringify(this.items));
    this.updateTotal();
    this.render();
  },

  syncRoomSelection() {
    const savedRoom = localStorage.getItem("selected_room");
    const roomInput = document.querySelector('[name="room_no"]');
    if (savedRoom && roomInput) {
      roomInput.value = savedRoom;
    }
  },

  render() {
    this.renderSidebar();
    this.renderCheckout();
  },

  renderSidebar() {
    const container = document.getElementById("cart-items-container");
    if (!container) return;

    if (this.items.length === 0) {
      container.innerHTML =
        '<div class="text-center py-5 text-muted small"><i class="bi bi-cart3 fs-2 d-block mb-2 opacity-25"></i>Your cart is empty</div>';
      return;
    }

    container.innerHTML = this.items
      .map(
        (item) => `
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom border-light pb-3">
                <div class="d-flex align-items-center gap-2">
                    <img src="/cafeteria-system-develop/uploads/products/${item.image || "default.png"}" class="rounded-3 shadow-sm" style="width: 40px; height: 40px; object-fit: cover;" onerror="this.src='https://placehold.co/40?text=Food'">
                    <div style="max-width: 100px;">
                        <div class="fw-bold small text-truncate text-dark">${item.name}</div>
                        <div class="text-warning fw-bold extra-small">${(item.price * item.quantity).toFixed(2)} EGP</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 bg-light rounded-pill px-2 py-1">
                    <button class="btn btn-sm p-0 m-0 border-0 btn-qty-down" data-id="${item.id}"><i class="bi bi-dash"></i></button>
                    <span class="small fw-bold mx-1" style="min-width: 15px; text-align: center;">${item.quantity}</span>
                    <button class="btn btn-sm p-0 m-0 border-0 btn-qty-up" data-id="${item.id}"><i class="bi bi-plus text-warning"></i></button>
                </div>
            </div>
        `,
      )
      .join("");
  },

  renderCheckout() {
    const container = document.getElementById("checkout-items-list");
    if (!container) return;

    if (this.items.length === 0) {
      container.innerHTML =
        '<div class="text-center py-5 text-muted">Your cart is currently empty. <a href="index.php?page=home" class="text-warning fw-bold">Order Now</a></div>';
      return;
    }

    container.innerHTML = this.items
      .map(
        (item) => `
            <div class="cart-item d-flex align-items-center justify-content-between py-4 border-bottom px-3 mb-2">
                <div class="d-flex align-items-center gap-4">
                    <img src="/cafeteria-system-develop/uploads/products/${item.image || "default.png"}" class="rounded-4 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;" onerror="this.src='https://placehold.co/70?text=Food'">
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">${item.name}</h6>
                        <p class="text-muted small mb-0">${item.price.toFixed(2)} EGP per unit</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="input-group input-group-sm rounded-pill border py-1 px-2" style="width: 110px; background: #fff;">
                        <button class="btn btn-sm btn-link text-dark p-0 border-0 btn-qty-down shadow-none" data-id="${item.id}"><i class="bi bi-dash fs-5"></i></button>
                        <input type="text" class="form-control bg-transparent border-0 text-center fw-bold p-0 shadow-none" value="${item.quantity}" readonly>
                        <button class="btn btn-sm btn-link text-warning p-0 border-0 btn-qty-up shadow-none" data-id="${item.id}"><i class="bi bi-plus fs-5"></i></button>
                    </div>
                    <div class="fw-bold fs-5 text-dark" style="min-width: 100px; text-align: right;">${(item.price * item.quantity).toFixed(2)} EGP</div>
                    <button class="btn btn-link text-danger p-0 border-0 btn-remove shadow-none" data-id="${item.id}"><i class="bi bi-trash3-fill fs-5"></i></button>
                </div>
            </div>
        `,
      )
      .join("");
  },

  setupEvents() {
    document.addEventListener("click", (e) => {
      const el = e.target.closest("button");
      if (!el) return;
      const id = parseInt(el.dataset.id);

      if (el.classList.contains("btn-add-to-cart")) {
        this.addToCart({
          id,
          name: el.dataset.name,
          price: parseFloat(el.dataset.price),
          image: el.dataset.image,
        });
      } else if (el.classList.contains("btn-qty-up")) {
        this.increaseQuantity(id);
      } else if (el.classList.contains("btn-qty-down")) {
        this.decreaseQuantity(id);
      } else if (el.classList.contains("btn-remove")) {
        this.removeItem(id);
      }
    });

    const form = document.getElementById("checkout-form");
    if (form) {
      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        if (this.items.length === 0)
          return Swal.fire(
            "Empty Cart",
            "Please add some items first!",
            "warning",
          );

        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML =
          '<span class="spinner-border spinner-border-sm me-2"></span> Processing Order...';

        const orderData = {
          user_id: window.userId,
          room_no: form.querySelector('[name="room_no"]').value,
          notes: form.querySelector('[name="notes"]').value,
          items: this.items,
        };

        try {
          const response = await fetch("index.php?page=confirm-order", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(orderData),
          });

          const result = await response.json();
          if (result.success) {
            this.items = [];
            this.save();
            Swal.fire({
              title: "Order Placed!",
              text: "Your order is being prepared.",
              icon: "success",
              confirmButtonColor: "#F59E0B",
            }).then(() => {
              window.location.href = "index.php?page=my-orders";
            });
          } else {
            Swal.fire("Order Failed", result.message, "error");
            btn.disabled = false;
            btn.innerHTML = originalText;
          }
        } catch (error) {
          console.error("Order Error:", error);
          Swal.fire(
            "Connection Error",
            "Could not reach server. Check your internet.",
            "error",
          );
          btn.disabled = false;
          btn.innerHTML = originalText;
        }
      });
    }
  },

  showFeedback(msg) {
    const toast = document.createElement("div");
    toast.className =
      "position-fixed bottom-0 start-50 translate-middle-x mb-5 bg-dark text-white px-4 py-2 rounded-pill shadow-lg z-3 border border-secondary";
    toast.style.animation = "fadeInUp 0.3s ease-out";
    toast.innerHTML = `<i class="bi bi-check-circle-fill text-warning me-2"></i> ${msg}`;
    document.body.appendChild(toast);
    setTimeout(() => {
      toast.style.animation = "fadeOutDown 0.3s ease-in";
      setTimeout(() => toast.remove(), 300);
    }, 2000);
  },
};

const style = document.createElement("style");
style.innerHTML = `
    @keyframes fadeInUp { from { opacity: 0; transform: translate(-50%, 20px); } to { opacity: 1; transform: translate(-50%, 0); } }
    @keyframes fadeOutDown { from { opacity: 1; transform: translate(-50%, 0); } to { opacity: 0; transform: translate(-50%, 20px); } }
    .extra-small { font-size: 0.65rem; }
`;
document.head.appendChild(style);

document.addEventListener("DOMContentLoaded", () => Cart.init());
