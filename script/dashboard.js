function enableEdit(button) {
      const row = button.closest("tr");
      row.querySelectorAll(".text").forEach(el => el.style.display = "none");
      row.querySelectorAll(".edit-input").forEach(el => el.style.display = "block");
      row.querySelector(".edit").style.display = "none";
      row.querySelector(".update").style.display = "inline-block";
    }