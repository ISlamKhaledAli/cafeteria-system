const PremiumAuth = {
  card: document.querySelector(".auth-card"),

  init() {
    this.bindEvents();
    this.initTiltEffect();
    console.log("Ultimate Auth Loaded: 3D Tilt + Strict Validation");
  },

  // 1. إضافة تأثير 3D تفاعلي مع حركة الماوس
  initTiltEffect() {
    if (!this.card) return;

    this.card.addEventListener("mousemove", (e) => {
      const rect = this.card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = ((y - centerY) / centerY) * -4; // الحد الأقصى للدوران 4 درجات
      const rotateY = ((x - centerX) / centerX) * 4;

      this.card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.01, 1.01, 1.01)`;
    });

    this.card.addEventListener("mouseleave", () => {
      this.card.style.transform =
        "perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)";
      this.card.style.transition =
        "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
    });

    this.card.addEventListener("mouseenter", () => {
      this.card.style.transition = "none";
    });
  },

  bindEvents() {
    // حركة التنقل بين الـ Login والـ Register
    document.querySelectorAll(".link-switch").forEach((link) => {
      link.addEventListener("click", (e) => {
        if (!link.hasAttribute("data-target")) return; // لو ده لينك عادي متعملش حاجة
        e.preventDefault();
        const isToReg = link.dataset.target === "register";

        this.card.style.transform = "scale(0.95)";
        setTimeout(() => {
          if (isToReg) this.card.classList.add("register-active");
          else this.card.classList.remove("register-active");
          this.card.style.transform =
            "perspective(1000px) rotateX(0) rotateY(0) scale3d(1,1,1)";
        }, 150);
      });
    });

    // إظهار/إخفاء الباسورد
    document.querySelectorAll(".password-toggle").forEach((btn) => {
      btn.addEventListener("click", () => {
        const input = btn.parentElement.querySelector("input");
        const isPass = input.type === "password";
        input.type = isPass ? "text" : "password";
        const icon = btn.querySelector("i");
        icon.classList.toggle("bi-eye");
        icon.classList.toggle("bi-eye-slash");
      });
    });

    // تأثير الفوكس على الـ Inputs
    document.querySelectorAll(".premium-input").forEach((input) => {
      input.addEventListener("focus", () =>
        input.closest(".input-holder").classList.add("focused"),
      );
      input.addEventListener("blur", () =>
        input.closest(".input-holder").classList.remove("focused"),
      );
    });

    // 2. التحقق الصارم (Strict Validation) قبل الإرسال
    document.querySelectorAll("form").forEach((form) => {
      form.addEventListener("submit", (e) => {
        const btn = form.querySelector(".btn-premium");
        const emailInput = form.querySelector('input[type="email"]');
        const passInput = form.querySelector('input[type="password"]');
        let valid = true;

        // التحقق من صحة الإيميل
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput && !emailRegex.test(emailInput.value)) {
          valid = false;
          this.showError(emailInput);
        }

        // التحقق من طول الباسورد (6 حروف على الأقل)
        if (passInput && passInput.value.length < 6) {
          valid = false;
          this.showError(passInput);
        }

        if (!valid) {
          e.preventDefault();
        } else {
          btn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
          btn.style.pointerEvents = "none";
          btn.style.opacity = "0.8";
        }
      });
    });

    // تغيير اسم الصورة المرفوعة
    document
      .getElementById("profileImage")
      ?.addEventListener("change", function (e) {
        const fileName =
          e.target.files[0]?.name || "Upload Profile Picture (Optional)";
        document.getElementById("fileNameDisplay").textContent = fileName;
      });
  },

  showError(input) {
    input.style.borderColor = "#EF4444";
    input.style.boxShadow = "0 0 0 4px rgba(239, 68, 68, 0.2)";
    setTimeout(() => {
      input.style.borderColor = "";
      input.style.boxShadow = "";
    }, 2000);
  },
};

document.addEventListener("DOMContentLoaded", () => PremiumAuth.init());
