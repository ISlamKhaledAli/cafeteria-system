function previewImage(event) {
  const file = event.target.files[0];
  if (!file) return;

  const validTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
  if (!validTypes.includes(file.type)) {
    alert("Please select a valid image file (JPG, PNG, GIF, WEBP).");
    event.target.value = "";
    return;
  }

  const maxSize = 2 * 1024 * 1024; // 2MB
  if (file.size > maxSize) {
    alert("Image size must be less than 2MB.");
    event.target.value = "";
    return;
  }

  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById("imagePreview");
    output.innerHTML = `<img src="${reader.result}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">`;
    output.style.border = "none";
  };
  reader.readAsDataURL(file);
}

document.addEventListener("DOMContentLoaded", function () {
  const userForms = document.querySelectorAll("form");

  userForms.forEach((form) => {
    form.addEventListener("submit", function (event) {
      const passwordInput = form.querySelector('input[name="password"]');
      const nameInput = form.querySelector('input[name="name"]');

      if (passwordInput && passwordInput.value.trim() !== "") {
        if (passwordInput.value.length < 6) {
          event.preventDefault();
          alert("Password must be at least 6 characters long.");
          passwordInput.focus();
          return;
        }
      }

      if (nameInput && nameInput.value.trim().length < 3) {
        event.preventDefault();
        alert("Please enter a valid full name.");
        nameInput.focus();
        return;
      }
    });
  });
});
