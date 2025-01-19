
<input type="text" name="full_name" oninput="validateLetters(this)" class="form-control" placeholder="Enter Full Name">

<input type="text" name="mobile_no" oninput="validateNumbers(this)" class="form-control" placeholder="Enter Mobile No">

  <script>
    // Function to allow only letters
    function validateLetters(input) {
      input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }


    // Function to allow only numbers
    function validateNumbers(input) {
      input.value = input.value.replace(/[^0-9]/g, '').substring(0, 10);
    }
  </script>