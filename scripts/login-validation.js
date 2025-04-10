//all my code, this js script is for form validation
document.addEventListener('DOMContentLoaded', function() { 
    
    function validateForm(form) {
        const email = form.querySelector('[name="email"]');
        const password = form.querySelector('[name="password"]');
        let isValid = true;

        // email validation- makes sure email is in the correct format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value.trim())) {
            displayError(email, 'Please enter a valid email address');
            isValid = false;
        } else {
            clearError(email);
        }

        // password validation, error message will come up if password is below 6 
        if (password.value.trim().length < 6) {
            displayError(password, 'Password must be at least 6 characters long');
            isValid = false;
        } else {
            clearError(password);
        }

        return isValid;
    }//function to display error message 
    function displayError(input, message) {
        clearError(input); //removes the existing error
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message'; 
        errorDiv.textContent = message;
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
        input.classList.add('input-error');
    }

    function clearError(input) { //function removing exisitng error messages 
        const errorMessage = input.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
        input.classList.remove('input-error');
    }
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(this)) {
                event.preventDefault();
            }
        });
    });
});