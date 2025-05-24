function togglePassword(id, iconSpan) {
  const input = document.getElementById(id);
  const icon = iconSpan.querySelector("i");

  input.type = input.type === "password" ? "text" : "password";
  icon.classList.toggle("fa-eye");
  icon.classList.toggle("fa-eye-slash");
}

// Password match check
document.addEventListener("DOMContentLoaded", () => {
  const password = document.getElementById("password");
  const confirm = document.getElementById("confirm_password");
  const message = document.getElementById("password-message");

  if (password && confirm && message) {
    confirm.addEventListener("input", () => {
      if (confirm.value !== password.value) {
        message.classList.remove("hidden");
      } else {
        message.classList.add("hidden");
      }
    });
  }
});

function toggleLikeButton(event, btn) {
    event.preventDefault();
    btn.classList.toggle('liked');
    btn.textContent = btn.classList.contains('liked') ? 'Liked' : 'Like';
    btn.closest('form').submit();
}

function toggleLikeButton(button) {
  button.classList.toggle('liked');
}