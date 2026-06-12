(function () {
    'use strict';

    var flows = document.querySelectorAll('[data-mgrs-flow]');

    if (!flows.length) {
        return;
    }

    var fieldLabels = {
        service_type: 'Услуга',
        city_area: 'Град / район',
        from_address: 'От адрес',
        to_address: 'До адрес',
        floor: 'Етаж',
        has_elevator: 'Има ли асансьор?',
        parking_access: 'Може ли бусът да спре близо?',
        demo_distance_km: 'Примерно разстояние в км',
        items_description: 'Кратко описание',
        boxes_bags_count: 'Брой кашони / чували',
        heavy_items: 'Тежки или специфични предмети',
        disassembly_needed: 'Нужно ли е разглобяване?',
        extra_services: 'Допълнителни услуги',
        notes: 'Допълнителни бележки',
        contact_name: 'Име',
        contact_phone: 'Телефон',
        contact_email: 'Email',
        contact_time: 'Удобно време за обаждане',
        request_urgency: 'Колко спешна е заявката?'
    };

    var optionLabels = {
        service_type: {
            moving_home: 'Преместване на жилище',
            moving_office: 'Преместване на офис',
            moving_helpers: 'Хамалски услуги',
            transport_van: 'Транспорт с бус',
            clearing: 'Изхвърляне / разчистване',
            other: 'Друго'
        },
        has_elevator: {
            yes: 'Да',
            no: 'Не'
        },
        disassembly_needed: {
            yes: 'Да',
            no: 'Не'
        },
        extra_services: {
            packing: 'Опаковане',
            disassembly: 'Демонтаж',
            assembly: 'Монтаж',
            disposal: 'Изхвърляне',
            carry_up_stairs: 'Качване по стълби',
            carry_down_stairs: 'Сваляне по стълби'
        },
        request_urgency: {
            urgent: 'Спешно',
            this_week: 'Тази седмица',
            flexible: 'Гъвкаво'
        }
    };

    flows.forEach(function (flow) {
        var steps = Array.prototype.slice.call(flow.querySelectorAll('[data-mgrs-step]'));
        var fields = Array.prototype.slice.call(flow.querySelectorAll('[data-mgrs-field]'));
        var backButton = flow.querySelector('[data-mgrs-back]');
        var nextButton = flow.querySelector('[data-mgrs-next]');
        var submitButton = flow.querySelector('[data-mgrs-submit]');
        var form = flow.querySelector('[data-mgrs-form]');
        var errorMessage = flow.querySelector('[data-mgrs-error]');
        var stepText = flow.querySelector('[data-mgrs-step-text]');
        var progressLabel = flow.querySelector('[data-mgrs-progress-label]');
        var progressBar = flow.querySelector('[data-mgrs-progress-bar]');
        var summary = flow.querySelector('[data-mgrs-summary]');
        var summaryList = flow.querySelector('[data-mgrs-summary-list]');
        var estimate = flow.querySelector('[data-mgrs-estimate]');
        var estimateValue = flow.querySelector('[data-mgrs-estimate-value]');
        var liveEstimate = flow.querySelector('[data-mgrs-live-estimate]');
        var liveEstimateValue = flow.querySelector('[data-mgrs-live-estimate-value]');
        var currentStep = 0;

        function getVisibleStep() {
            return steps[currentStep];
        }

        function normalizedName(field) {
            return String(field.name || '').replace(/\[\]$/, '');
        }

        function labelFor(name, value) {
            if (optionLabels[name] && optionLabels[name][value]) {
                return optionLabels[name][value];
            }

            return value;
        }

        function fieldValue(field) {
            if ('checkbox' === field.type) {
                return field.checked ? labelFor(normalizedName(field), field.value) : '';
            }

            return labelFor(normalizedName(field), String(field.value || '').trim());
        }

        function rawFieldValue(field) {
            if ('checkbox' === field.type) {
                return field.checked ? String(field.value || '').trim() : '';
            }

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
                stepText.textContent = 'Стъпка ' + stepNumber + ' от ' + steps.length;
            }

            if (progressLabel) {
                progressLabel.textContent = percent + '% завършено';
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

            if (liveEstimate) {
                liveEstimate.hidden = false;
            }

            currentStep = index;
            clearError();
            updateProgress();
            updateLiveEstimate();

            if (backButton) {
                backButton.hidden = currentStep === 0;
            }

            if (nextButton) {
                nextButton.textContent = currentStep === steps.length - 1 ? 'Преглед' : 'Напред';
                nextButton.hidden = false;
            }

            if (submitButton) {
                submitButton.hidden = true;
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
                showError('Моля, попълнете задължителните полета, преди да продължите.');
                missingFields[0].focus();
                return false;
            }

            clearError();
            return true;
        }

        function summaryValues() {
            var values = {};

            fields.forEach(function (field) {
                var name = normalizedName(field);
                var value = fieldValue(field);

                if ('' === value) {
                    return;
                }

                if (!values[name]) {
                    values[name] = [];
                }

                values[name].push(value);
            });

            return values;
        }

        function rawValues() {
            var values = {};

            fields.forEach(function (field) {
                var name = normalizedName(field);
                var value = rawFieldValue(field);

                if ('' === value) {
                    return;
                }

                if (!values[name]) {
                    values[name] = [];
                }

                values[name].push(value);
            });

            return values;
        }

        function numberValue(value) {
            var normalized = String(value || '').replace(',', '.');
            var parsed = Number(normalized);

            return Number.isFinite(parsed) && parsed > 0 ? parsed : 0;
        }

        function roundToNearestFive(value) {
            return Math.round(value / 5) * 5;
        }

        function calculateEstimate(values) {
            var serviceType = values.service_type && values.service_type[0] ? values.service_type[0] : 'other';
            var basePrices = {
                moving_home: 80,
                moving_office: 120,
                moving_helpers: 60,
                transport_van: 70,
                clearing: 90,
                other: 80
            };
            var extraPrices = {
                packing: 15,
                disassembly: 20,
                assembly: 20,
                disposal: 20,
                carry_up_stairs: 10,
                carry_down_stairs: 10
            };
            var urgencyPrices = {
                urgent: 30,
                this_week: 10,
                flexible: 0
            };
            var total = basePrices[serviceType] || basePrices.other;
            var boxes = numberValue(values.boxes_bags_count && values.boxes_bags_count[0]);
            var floor = numberValue(values.floor && values.floor[0]);
            var distance = Math.min(300, numberValue(values.demo_distance_km && values.demo_distance_km[0]));
            var urgency = values.request_urgency && values.request_urgency[0] ? values.request_urgency[0] : '';
            var extras = values.extra_services || [];

            total += boxes * 3;
            total += values.heavy_items && values.heavy_items[0] ? 15 : 0;
            total += values.has_elevator && values.has_elevator[0] === 'no' ? floor * 10 : 0;
            total += distance * 2;
            total += urgencyPrices[urgency] || 0;

            extras.forEach(function (extra) {
                total += extraPrices[extra] || 0;
            });

            return {
                low: roundToNearestFive(total * 0.85),
                high: roundToNearestFive(total * 1.15)
            };
        }

        function formatEstimateRange(estimateRange) {
            return estimateRange.low + ' - ' + estimateRange.high + ' лв';
        }

        function updateLiveEstimate() {
            if (!liveEstimateValue) {
                return;
            }

            var values = rawValues();

            if (!values.service_type || !values.service_type[0]) {
                liveEstimateValue.textContent = 'Попълнете данните, за да видите примерна цена.';
                return;
            }

            liveEstimateValue.textContent = formatEstimateRange(calculateEstimate(values));
        }

        function renderSummary() {
            if (!summary || !summaryList) {
                return;
            }

            var values = summaryValues();
            var estimateRange = calculateEstimate(rawValues());

            summaryList.innerHTML = '';

            if (estimate && estimateValue) {
                estimateValue.textContent = formatEstimateRange(estimateRange);
                estimate.hidden = false;
            }

            Object.keys(fieldLabels).forEach(function (name) {
                var item = document.createElement('div');
                var term = document.createElement('dt');
                var description = document.createElement('dd');
                var value = values[name] && values[name].length ? values[name].join(', ') : 'Не е посочено';

                item.className = 'mgrs-flow__summary-item';
                term.className = 'mgrs-flow__summary-term';
                description.className = 'mgrs-flow__summary-description';
                term.textContent = fieldLabels[name] || name;
                description.textContent = value;

                item.appendChild(term);
                item.appendChild(description);
                summaryList.appendChild(item);
            });

            steps.forEach(function (step) {
                step.hidden = true;
            });

            summary.hidden = false;

            if (liveEstimate) {
                liveEstimate.hidden = true;
            }

            if (stepText) {
                stepText.textContent = 'Преглед';
            }

            if (progressLabel) {
                progressLabel.textContent = 'Готово за изпращане';
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

            if (submitButton) {
                submitButton.hidden = false;
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
            field.addEventListener('input', function () {
                clearError();
                updateLiveEstimate();
            });
            field.addEventListener('change', function () {
                clearError();
                updateLiveEstimate();
            });
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

                    if (submitButton) {
                        submitButton.hidden = true;
                    }

                    showStep(steps.length - 1);
                    return;
                }

                showStep(Math.max(0, currentStep - 1));
            });
        }

        if (form && submitButton) {
            form.addEventListener('submit', function (event) {
                if (summary && summary.hidden) {
                    event.preventDefault();

                    if (nextButton) {
                        nextButton.click();
                    }

                    return;
                }

                submitButton.disabled = true;
                submitButton.textContent = 'Изпращане...';
            });
        }

        showStep(0);
    });
}());
