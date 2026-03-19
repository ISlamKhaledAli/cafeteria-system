function previewImage(event) {
  const file = event.target.files[0];
  if (!file) return;

  const validTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
  if (!validTypes.includes(file.type)) {
    Swal.fire({
      icon: "error",
      title: "Invalid File",
      text: "Please select a valid image file (JPG, PNG, GIF, WEBP).",
      confirmButtonColor: "#d97706",
    });
    event.target.value = "";
    return;
  }

  const maxSize = 2 * 1024 * 1024; // 2MB
  if (file.size > maxSize) {
    Swal.fire({
      icon: "warning",
      title: "File Too Large",
      text: "Image size must be less than 2MB.",
      confirmButtonColor: "#d97706",
    });
    event.target.value = "";
    return;
  }

  const reader = new FileReader();
  reader.onload = function () {
    const output = document.getElementById("imagePreview");
    output.style.opacity = "0";
    output.style.backgroundImage = `url(${reader.result})`;
    output.style.backgroundSize = "cover";
    output.style.backgroundPosition = "center";
    output.innerHTML = "";
    output.style.borderColor = "#d97706";

    setTimeout(() => {
      output.style.transition = "opacity 0.4s ease-in";
      output.style.opacity = "1";
    }, 50);
  };
  reader.readAsDataURL(file);
}

document.addEventListener("DOMContentLoaded", function () {
  const userForms = document.querySelectorAll("form");

  const card = document.querySelector(".card");
  if (card) {
    card.style.opacity = "0";
    card.style.transform = "translateY(20px)";
    setTimeout(() => {
      card.style.transition = "all 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
      card.style.opacity = "1";
      card.style.transform = "translateY(0)";
    }, 100);
  }

  userForms.forEach((form) => {
    form.addEventListener("submit", function (event) {
      const passwordInput = form.querySelector('input[name="password"]');
      const nameInput = form.querySelector('input[name="name"]');

      if (passwordInput && passwordInput.value.trim() !== "") {
        if (passwordInput.value.length < 6) {
          event.preventDefault();
          Swal.fire({
            icon: "warning",
            title: "Weak Password",
            text: "Password must be at least 6 characters long.",
            confirmButtonColor: "#d97706",
          }).then(() => passwordInput.focus());
          return;
        }
      }

      if (nameInput && nameInput.value.trim().length < 3) {
        event.preventDefault();
        Swal.fire({
          icon: "warning",
          title: "Invalid Name",
          text: "Please enter a valid full name (at least 3 characters).",
          confirmButtonColor: "#d97706",
        }).then(() => nameInput.focus());
        return;
      }

      const btn = form.querySelector('button[type="submit"]');
      if (btn) {
        const originalText = btn.innerHTML;
        btn.innerHTML =
          '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
        btn.classList.add("disabled");
      }
    });
  });
});
