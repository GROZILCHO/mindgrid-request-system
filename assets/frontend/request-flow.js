(function () {
    'use strict';

    var flows = document.querySelectorAll('[data-mgrs-flow]');

    if (!flows.length) {
        return;
    }

    var fieldLabels = {
        service_type: 'Service type',
        city_area: 'City / area',
        floor: 'Floor',
        has_elevator: 'Elevator access',
        parking_access: 'Parking / loading access',
        items: 'Items',
        extra_services: 'Extra services',
        notes: 'Notes',
        contact_name: 'Contact name',
        contact_phone: 'Contact phone',
        contact_email: 'Contact email'
    };

    flows.forEach(function (flow) {
        var steps = Array.prototype.slice.call(flow.querySelectorAll('[data-mgrs-step]'));
        var fields = Array.prototype.slice.call(flow.querySelectorAll('[data-mgrs-field]'));
        var backButton = flow.querySelector('[data-mgrs-back]');
        var nextButton = flow.querySelector('[data-mgrs-next]');
        var errorMessage = flow.querySelector('[data-mgrs-error]');
        var stepText = flow.querySelector('[data-mgrs-step-text]');
        var progressLabel = flow.querySelector('[data-mgrs-progress-label]');
        var progressBar = flow.querySelector('[data-mgrs-progress-bar]');
        var summary = flow.querySelector('[data-mgrs-summary]');
        var summaryList = flow.querySelector('[data-mgrs-summary-list]');
        var currentStep = 0;

        function getVisibleStep() {
            return steps[currentStep];
        }

        function fieldValue(field) {
            return String(field.value || '').trim();
        }

        function clearError() {
            if (!errorMessage) {
                return;
            }

            errorMessage.hidden = true;
            errorMessage.textContent = '';
        }

        function showError(message) {
            if (!errorMessage) {
                return;
            }

            errorMessage.textContent = message;
            errorMessage.hidden = false;
            errorMessage.focus();
        }

        function updateProgress() {
            var stepNumber = Math.min(currentStep + 1, steps.length);
            var percent = Math.round((stepNumber / steps.length) * 100);

            if (stepText) {
                stepText.textContent = 'Step ' + stepNumber + ' of ' + steps.length;
            }

            if (progressLabel) {
                progressLabel.textContent = percent + '% complete';
            }

            if (progressBar) {
                progressBar.style.width = percent + '%';
            }
        }

        function showStep(index) {
            steps.forEach(function (step, stepIndex) {
                step.hidden = stepIndex !== index;
            });

            if (summary) {
                summary.hidden = true;
            }

            currentStep = index;
            clearError();
            updateProgress();

            if (backButton) {
                backButton.hidden = currentStep === 0;
            }

            if (nextButton) {
                nextButton.textContent = currentStep === steps.length - 1 ? 'Review' : 'Next';
            }

            var firstField = getVisibleStep().querySelector('[data-mgrs-field]');

            if (firstField) {
                firstField.focus();
            }
        }

        function validateCurrentStep() {
            var requiredFields = Array.prototype.slice.call(getVisibleStep().querySelectorAll('[data-mgrs-required]'));
            var missingFields = requiredFields.filter(function (field) {
                return fieldValue(field) === '';
            });

            if (missingFields.length) {
                showError('Please complete required fields before continuing.');
                missingFields[0].focus();
                return false;
            }

            clearError();
            return true;
        }

        function renderSummary() {
            if (!summary || !summaryList) {
                return;
            }

            summaryList.innerHTML = '';

            fields.forEach(function (field) {
                var value = fieldValue(field);
                var item = document.createElement('div');
                var term = document.createElement('dt');
                var description = document.createElement('dd');

                item.className = 'mgrs-flow__summary-item';
                term.className = 'mgrs-flow__summary-term';
                description.className = 'mgrs-flow__summary-description';
                term.textContent = fieldLabels[field.name] || field.name;
                description.textContent = value || 'Not provided';

                item.appendChild(term);
                item.appendChild(description);
                summaryList.appendChild(item);
            });

            steps.forEach(function (step) {
                step.hidden = true;
            });

            summary.hidden = false;

            if (stepText) {
                stepText.textContent = 'Review';
            }

            if (progressLabel) {
                progressLabel.textContent = 'Prototype summary';
            }

            if (progressBar) {
                progressBar.style.width = '100%';
            }

            if (backButton) {
                backButton.hidden = false;
            }

            if (nextButton) {
                nextButton.hidden = true;
            }

            summary.focus();
        }

        if (errorMessage) {
            errorMessage.setAttribute('tabindex', '-1');
        }

        if (summary) {
            summary.setAttribute('tabindex', '-1');
        }

        fields.forEach(function (field) {
            field.addEventListener('input', clearError);
            field.addEventListener('change', clearError);
        });

        if (nextButton) {
            nextButton.addEventListener('click', function () {
                if (!validateCurrentStep()) {
                    return;
                }

                if (currentStep === steps.length - 1) {
                    renderSummary();
                    return;
                }

                showStep(currentStep + 1);
            });
        }

        if (backButton) {
            backButton.addEventListener('click', function () {
                if (summary && !summary.hidden) {
                    if (nextButton) {
                        nextButton.hidden = false;
                    }

                    showStep(steps.length - 1);
                    return;
                }

                showStep(Math.max(0, currentStep - 1));
            });
        }

        showStep(0);
    });
}());
