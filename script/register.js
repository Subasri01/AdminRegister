function validateForm() {
      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const age = document.getElementById('age').value.trim();
      const gender = document.getElementById('gender').value;
      const password = document.getElementById('password').value.trim();

      if (!name || !email || !phone || !age || !gender || !password) {
        alert("Please fill in all fields.");
        return false;
      }

    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(name)) {
      alert("Name must contain only letters and spaces.");
      return false;
    }
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/i;
      if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
      }

      const phonePattern = /^\d{10,}$/;
      if (!phonePattern.test(phone)) {
        alert("Phone number must be at least 10 digits and contain only numbers.");
        return false;
      }

      const ageNum = parseInt(age);
      if (isNaN(ageNum) || ageNum <= 0 || ageNum > 120) {
        alert("Please enter a valid age between 1 and 120.");
        return false;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
      }

      return true;
    }
  