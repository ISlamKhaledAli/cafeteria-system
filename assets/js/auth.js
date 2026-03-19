/**
 * ULTIMATE Premium Auth Logic - Cafeteria System
 * Polished transitions and micro-interactions.
 */

const PremiumAuth = {
<<<<<<< HEAD
<<<<<<< HEAD
  card: document.querySelector(".auth-card"),

  init() {
    this.bindEvents();
    console.log("Ultimate Auth Polished Logic Loaded");
  },

  bindEvents() {
    // --- Form Switch with Advanced Scaling ---
    document.querySelectorAll(".link-switch").forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const isToReg = link.dataset.target === "register";

        // Add scale pop for "feel alive" effect
        this.card.style.transform = "scale(0.98)";

        setTimeout(() => {
          if (isToReg) {
            this.card.classList.add("register-active");
          } else {
            this.card.classList.remove("register-active");
          }
          this.card.style.transform = "scale(1)";
        }, 150);
      });
    });

    // --- Password Toggle Refinement ---
    document.querySelectorAll(".password-toggle").forEach((btn) => {
      btn.addEventListener("click", () => {
        const input = btn.parentElement.querySelector("input");
        const isPass = input.type === "password";
        input.type = isPass ? "text" : "password";

        const icon = btn.querySelector("i");
        icon.classList.toggle("bi-eye");
        icon.classList.toggle("bi-eye-slash");

        // Add subtle scale animation to icon
        icon.style.transform = "scale(1.2)";
        setTimeout(() => (icon.style.transform = "scale(1)"), 200);
      });
    });

    // --- Input Focus States ---
    document.querySelectorAll(".premium-input").forEach((input) => {
      input.addEventListener("focus", () => {
        input.closest(".input-holder").classList.add("focused");
      });
      input.addEventListener("blur", () => {
        input.closest(".input-holder").classList.remove("focused");
      });
    });

    // --- Smooth Form Validation & Loading ---
    document.querySelectorAll("form").forEach((form) => {
      form.addEventListener("submit", (e) => {
        const btn = form.querySelector(".btn-premium");
        const inputs = form.querySelectorAll("[required]");
        let valid = true;

        inputs.forEach((input) => {
          if (!input.value.trim()) {
            valid = false;
            input.style.borderColor = "#EF4444";
            setTimeout(() => (input.style.borderColor = ""), 1000);
          }
        });

        if (valid) {
          btn.innerHTML = '<span class="loading-spinner"></span>';
          btn.classList.add("loading");
        } else {
          e.preventDefault();
        }
      });
    });
  },
};

document.addEventListener("DOMContentLoaded", () => PremiumAuth.init());
=======
=======
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
    card: document.querySelector('.auth-card'),
    
    init() {
        this.bindEvents();
        console.log("Ultimate Auth Polished Logic Loaded");
    },

    bindEvents() {
        document.querySelectorAll('.link-switch').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const isToReg = link.dataset.target === 'register';
                
                this.card.style.transform = 'scale(0.98)';
                
                setTimeout(() => {
                    if (isToReg) {
                        this.card.classList.add('register-active');
                    } else {
                        this.card.classList.remove('register-active');
                    }
                    this.card.style.transform = 'scale(1)';
                }, 150);
            });
        });

        document.querySelectorAll('.password-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.parentElement.querySelector('input');
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                
                const icon = btn.querySelector('i');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
                
                icon.style.transform = 'scale(1.2)';
                setTimeout(() => icon.style.transform = 'scale(1)', 200);
            });
        });

        document.querySelectorAll('.premium-input').forEach(input => {
            input.addEventListener('focus', () => {
                input.closest('.input-holder').classList.add('focused');
            });
            input.addEventListener('blur', () => {
                input.closest('.input-holder').classList.remove('focused');
            });
        });

         document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const btn = form.querySelector('.btn-premium');
                const inputs = form.querySelectorAll('[required]');
                let valid = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        valid = false;
                        input.style.borderColor = '#EF4444';
                        setTimeout(() => input.style.borderColor = '', 1000);
                    }
                });

                if (valid) {
                    btn.innerHTML = '<span class="loading-spinner"></span>';
                    btn.classList.add('loading');
                } else {
                    e.preventDefault();
                }
            });
        });
    }
};

document.addEventListener('DOMContentLoaded', () => PremiumAuth.init());
<<<<<<< HEAD
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
=======
>>>>>>> 0289bb93717993938ae4d7f277d25ea1433930e8
