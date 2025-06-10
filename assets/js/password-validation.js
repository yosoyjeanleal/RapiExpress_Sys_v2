document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar ambos tipos de campos de contraseña
    const passwordFields = [
        document.querySelector('input[name="password"]'),
        document.querySelector('input[name="newPassword"]')
    ].filter(Boolean); // Elimina null si no existe el campo

    passwordFields.forEach(passwordInput => {
        passwordInput.classList.add('password-input');

        const passwordContainer = passwordInput.closest('.input-group.custom');
        const validationContainer = document.createElement('div');
        validationContainer.className = 'password-validation-container';

        validationContainer.innerHTML = `
            <div class="password-validation-title">
                <i class="icon-copy dw dw-shield"></i>
                Requisitos de contraseña
            </div>
            <ul class="password-validation-list">
                <li id="${passwordInput.name}-length" data-min="8">8+ caracteres</li>
                <li id="${passwordInput.name}-uppercase">1 mayúscula</li>
                <li id="${passwordInput.name}-lowercase">1 minúscula</li>
                <li id="${passwordInput.name}-number">1 número</li>
                <li id="${passwordInput.name}-special">1 especial (!@#$%^&*)</li>
            </ul>
            <div class="password-strength-meter">
                <div class="password-strength-meter-fill" id="${passwordInput.name}-strength-bar"></div>
            </div>
            <div class="password-strength-text" id="${passwordInput.name}-strength-text">Seguridad: muy débil</div>
        `;

        passwordContainer.parentNode.insertBefore(validationContainer, passwordContainer.nextSibling);

        passwordInput.addEventListener('focus', function () {
            validationContainer.classList.add('active');
        });

        passwordInput.addEventListener('blur', function () {
            if (this.value === '') {
                validationContainer.classList.remove('active');
            }
        });

        passwordInput.addEventListener('input', function () {
            const password = this.value;

            if (password.length > 0 && !validationContainer.classList.contains('active')) {
                validationContainer.classList.add('active');
            }

            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*]/.test(password)
            };

            Object.keys(requirements).forEach(key => {
                const element = document.getElementById(`${passwordInput.name}-${key}`);
                if (element) {
                    element.classList.toggle('valid', requirements[key]);
                }
            });

            updatePasswordStrength(password, requirements, passwordInput.name);
        });

        function updatePasswordStrength(password, requirements, fieldName) {
            const strengthBar = document.getElementById(`${fieldName}-strength-bar`);
            const strengthText = document.getElementById(`${fieldName}-strength-text`);
            let strength = 0;
            let fulfilledRequirements = 0;

            Object.keys(requirements).forEach(key => {
                if (requirements[key]) fulfilledRequirements++;
            });

            strength = (fulfilledRequirements / 5) * 100;
            if (password.length > 12) strength += 10;
            if (password.length > 16) strength += 10;
            strength = Math.min(strength, 100);

            let strengthLevel = '';
            let strengthColor = '';

            if (strength < 40) {
                strengthLevel = 'Muy débil';
                strengthColor = '#e74c3c';
                passwordInput.classList.remove('password-field-medium', 'password-field-strong');
                passwordInput.classList.add('password-field-weak');
            } else if (strength < 75) {
                strengthLevel = 'Moderada';
                strengthColor = '#f39c12';
                passwordInput.classList.remove('password-field-weak', 'password-field-strong');
                passwordInput.classList.add('password-field-medium');
            } else {
                strengthLevel = 'Fuerte';
                strengthColor = '#27ae60';
                passwordInput.classList.remove('password-field-weak', 'password-field-medium');
                passwordInput.classList.add('password-field-strong');
            }

            strengthBar.style.width = strength + '%';
            strengthBar.style.backgroundColor = strengthColor;
            strengthText.textContent = `Seguridad: ${strengthLevel}`;
            strengthText.style.color = strengthColor;
        }
    });

    // Validar antes de enviar formularios
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            let allValid = true;

            passwordFields.forEach(passwordInput => {
                if (form.contains(passwordInput)) {
                    const password = passwordInput.value;
                    const requirements = {
                        length: password.length >= 8,
                        uppercase: /[A-Z]/.test(password),
                        lowercase: /[a-z]/.test(password),
                        number: /[0-9]/.test(password),
                        special: /[!@#$%^&*]/.test(password)
                    };

                    const fieldValid = Object.values(requirements).every(valid => valid);
                    allValid = allValid && fieldValid;

                    if (!fieldValid) {
                        const validationContainer = passwordInput.nextElementSibling;
                        if (validationContainer && validationContainer.classList.contains('password-validation-container')) {
                            validationContainer.classList.add('active');
                            validationContainer.style.animation = 'shake 0.5s';
                            setTimeout(() => {
                                validationContainer.style.animation = '';
                            }, 500);
                        }
                        passwordInput.focus();
                    }
                }
            });

            if (!allValid) {
                e.preventDefault();
                alert('Por favor, asegúrate de que todas las contraseñas cumplan con los requisitos.');
            }
        });
    });

});

