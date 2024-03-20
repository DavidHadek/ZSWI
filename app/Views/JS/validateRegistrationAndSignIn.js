/**
 * Validates the entered username.
 *
 * @returns {boolean} - True if the username is valid, false otherwise.
 */
/*function validateUsername() {
    let usernameInput = document.getElementById('username');
    let username = usernameInput.value.trim();
    let validationMessage = document.getElementById('username-validation-message');

    if (username.length > 50) {
        validationMessage.textContent = 'Username length must be less than 50 characters.';
        validationMessage.style.color = 'red';
        return false;
    } else {
        validationMessage.textContent = '';
        return true;
    }
}*/

/**
 * Validates the entered email address.
 *
 * @returns {boolean} - True if the email address is valid, false otherwise.
 */
function validateEmail() {
    let email = document.getElementById('email').value.trim();
    let validationMessage = document.getElementById('email-validation-message');

    // Regular expression for a simple email validation
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        validationMessage.textContent = 'Not a valid email address!';
        validationMessage.style.color = 'red';
        return false;
    } else if (email.length > 128) {
        validationMessage.textContent = 'Email length must be less than 128 characters.';
        validationMessage.style.color = 'red';
        return false;
    } else {
        validationMessage.textContent = '';
        return true;
    }
}

/**
 * Validates the entered password based on certain criteria.
 *
 * @returns {boolean} - True if the password is valid, false otherwise.
 */
function validatePassword() {
    let password = document.getElementById('password').value;
    let validationMessage = document.getElementById('password-validation-message');

    validationMessage.style.color = 'red';

    if (password.length < 8) {
        validationMessage.textContent = 'Password must be at least 8 characters long!';
        return false;
    } else if (!/[A-Z]/.test(password)) {
        validationMessage.textContent = 'Password must include at least one uppercase letter!';
        return false;
    } else if (!/[a-z]/.test(password)) {
        validationMessage.textContent = 'Password must include at least one lowercase letter!';
        return false;
    } else if (!/\d/.test(password)) {
        validationMessage.textContent = 'Password must include at least one number!';
        return false;
    } else if (password.length > 128) {
        validationMessage.textContent = 'Password length must be less than 128 characters.';
        validationMessage.style.color = 'red';
        return false;
    }

    validationMessage.textContent = '';
    return true;
}

/**
 * Validates the repeated password to ensure it matches the original password.
 *
 * @returns {boolean} - True if the repeated password matches the original, false otherwise.
 */
function validatePasswordCheck() {
    let validationMessage = document.getElementById('password-check-validation-message');

    let passwordRepeat = document.getElementById('password2').value;
    if (passwordRepeat !== document.getElementById('password').value) {
        validationMessage.textContent = 'The passwords do not match!';
        validationMessage.style.color = 'red';
        return false;
    } else {
        validationMessage.textContent = '';
        return true;
    }
}

/**
 * Validates the agreement checkbox.
 *
 * @returns {boolean} - True if the checkbox is checked, false otherwise.
 */
/*function validateCheckbox() {
    let checkbox = document.getElementById('tos-checkbox');
    let validationMessage = document.getElementById('tos-checkbox-validation-message');

    if (!checkbox.checked) {
        validationMessage.textContent = 'You have to agree to the continue using our services.';
        validationMessage.style.color = 'red';
        return false;
    } else {
        validationMessage.textContent = '';
        return true;
    }
}*/

/**
 * Validates the entire form submission by checking all relevant fields.
 *
 * @returns {boolean} - True if all fields are valid, false otherwise.
 */
function validateSubmission() {
    return /*validateUsername() &&*/ validateEmail() && validatePassword()
        && validatePasswordCheck() /*&& validateCheckbox()*/;
}

/**
 * Toggles the visibility of a password input and updates the associated eye icon.
 *
 * @param {string} passwordInputID - The ID of the password input element.
 * @param {string} eyeIconID - The eye icon element associated with the password input.
 */
function togglePasswordVisibility(passwordInputID, eyeIconID) {
    const passwordInput = document.getElementById(passwordInputID);
    const eyeIcon = document.getElementById(eyeIconID);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}