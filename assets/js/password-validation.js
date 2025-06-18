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
                ${jt('js_password_requirements_title', 'Password Requirements')}
            </div>
            <ul class="password-validation-list">
                <li id="${passwordInput.name}-length" data-min="8">${jt('js_req_length', '8+ characters')}</li>
                <li id="${passwordInput.name}-uppercase">${jt('js_req_uppercase', '1 uppercase')}</li>
                <li id="${passwordInput.name}-lowercase">${jt('js_req_lowercase', '1 lowercase')}</li>
                <li id="${passwordInput.name}-number">${jt('js_req_number', '1 number')}</li>
                <li id="${passwordInput.name}-special">${jt('js_req_special', '1 special char (!@#$%^&*)')}</li>
            </ul>
            <div class="password-strength-meter">
                <div class="password-strength-meter-fill" id="${passwordInput.name}-strength-bar"></div>
            </div>
            <div class="password-strength-text" id="${passwordInput.name}-strength-text">${jt('js_strength_label_prefix', 'Strength: ')}${jt('js_strength_very_weak', 'Very Weak')}</div>
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
                strengthLevel = jt('js_strength_very_weak', 'Very Weak');
                strengthColor = '#e74c3c';
                passwordInput.classList.remove('password-field-medium', 'password-field-strong');
                passwordInput.classList.add('password-field-weak');
            } else if (strength < 75) {
                strengthLevel = jt('js_strength_moderate', 'Moderate');
                strengthColor = '#f39c12';
                passwordInput.classList.remove('password-field-weak', 'password-field-strong');
                passwordInput.classList.add('password-field-medium');
            } else {
                strengthLevel = jt('js_strength_strong', 'Strong');
                strengthColor = '#27ae60';
                passwordInput.classList.remove('password-field-weak', 'password-field-medium');
                passwordInput.classList.add('password-field-strong');
            }

            strengthBar.style.width = strength + '%';
            strengthBar.style.backgroundColor = strengthColor;
            strengthText.textContent = `${jt('js_strength_label_prefix', 'Strength: ')}${strengthLevel}`;
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
                alert(jt('js_alert_password_requirements', 'Please ensure all passwords meet the requirements.'));
            }
        });
    });

});

