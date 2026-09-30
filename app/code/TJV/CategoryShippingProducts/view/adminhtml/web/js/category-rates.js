define(['mage/translate'], function ($t) {
    'use strict';

    return function (config, element) {
        const countrySelect = element.querySelector('[data-role="country-select"]');
        const countryTable = element.querySelector('[data-role="country-table"]');
        const tableHead = element.querySelector('[data-role="country-table-head"]');
        const tableRow = element.querySelector('[data-role="country-table-row"]');
        const countryControls = element.querySelector('.tjv-category-rates__country-controls');
        const otherDestinations = element.querySelector('.tjv-category-rates__other-destinations');
        const countryTemplate = element.querySelector('template[data-role="country-template"]');
        const regionTemplate = element.querySelector('template[data-role="region-template"]');
        const groupTemplate = element.querySelector('template[data-role="group-template"]');
        const groupNameInput = element.querySelector('[data-role="group-name"]');
        const groupCountriesSelect = element.querySelector('[data-role="group-countries"]');
        const groupSaveButton = element.querySelector('[data-action="group-countries"]');
        const cancelGroupEditButton = element.querySelector('[data-role="cancel-group-edit"]');
        const groupNameTemplate = countryControls &&
            countryControls.querySelector('template[data-role="country-group-name-template"]');
        const groupCountryTemplate = countryControls &&
            countryControls.querySelector('template[data-role="country-group-country-template"]');

        if (!countrySelect || !countryTable || !tableHead || !tableRow
            || !countryControls || !otherDestinations || !countryTemplate || !regionTemplate
            || !groupTemplate || !groupNameInput || !groupCountriesSelect
            || !groupNameTemplate || !groupCountryTemplate || !groupSaveButton
            || !cancelGroupEditButton
        ) {
            console.error('Category shipping country controls could not be initialized.');
            return;
        }

        let editingGroupId = null;

        function updateTableWidth() {
            const width = tableHead.children.length * 340 + 'px';

            countryTable.style.width = width;
            countryTable.style.minWidth = width;
        }

                // ---------- Column drag & drop ----------
        const orderAnchor = element.querySelector('[data-role="column-order-anchor"]');
        let draggedHead = null;

        function markColumnsDraggable() {
            tableHead.querySelectorAll('th[data-country-column]').forEach(function (th) {
                th.draggable = true;
                th.style.cursor = 'move';
                th.title = $t('Drag to reorder');
            });
        }

        function syncColumnOrder() {
            if (!orderAnchor) {
                return;
            }
            element.querySelectorAll('input[data-role="column-order"]').forEach(function (input) {
                input.remove();
            });
            tableHead.querySelectorAll('th[data-country-column]').forEach(function (th) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = orderAnchor.name;
                input.value = th.dataset.countryColumn;
                input.dataset.role = 'column-order';
                orderAnchor.parentNode.appendChild(input);
            });
        }

        function findBodyCell(key) {
            return Array.from(tableRow.querySelectorAll('td[data-country-column]'))
                .find(function (cell) {
                    return cell.dataset.countryColumn === key;
                });
        }

        function clearDragMarks() {
            tableHead.querySelectorAll('th').forEach(function (th) {
                th.style.outline = '';
                th.style.opacity = '';
            });
        }

        tableHead.addEventListener('dragstart', function (event) {
            const th = event.target instanceof Element ? event.target.closest('th[data-country-column]') : null;
            if (!th) {
                return;
            }
            draggedHead = th;
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', th.dataset.countryColumn); // required by Firefox
            th.style.opacity = '0.5';
        });

        tableHead.addEventListener('dragover', function (event) {
            const th = event.target instanceof Element ? event.target.closest('th[data-country-column]') : null;
            if (!draggedHead || !th || th === draggedHead) {
                return;
            }
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
            clearDragMarks();
            draggedHead.style.opacity = '0.5';
            th.style.outline = '2px dashed #eb5202';
        });

        tableHead.addEventListener('drop', function (event) {
            const target = event.target instanceof Element ? event.target.closest('th[data-country-column]') : null;
            if (!draggedHead || !target || target === draggedHead) {
                return;
            }
            event.preventDefault();

            const rect = target.getBoundingClientRect();
            const placeAfter = event.clientX > rect.left + rect.width / 2;
            const dragCell = findBodyCell(draggedHead.dataset.countryColumn);
            const targetCell = findBodyCell(target.dataset.countryColumn);

            tableHead.insertBefore(draggedHead, placeAfter ? target.nextSibling : target);
            if (dragCell && targetCell) {
                tableRow.insertBefore(dragCell, placeAfter ? targetCell.nextSibling : targetCell);
            }
            clearDragMarks();
            syncColumnOrder();
        });

        tableHead.addEventListener('dragend', function () {
            draggedHead = null;
            clearDragMarks();
        });

        // Columns added or removed (Add country, group create/remove) stay draggable and in the saved order
        new MutationObserver(function () {
            markColumnsDraggable();
            syncColumnOrder();
        }).observe(tableHead, {childList: true});

        markColumnsDraggable();

        function updateGroupedCountryOptions() {
            const groupedCountryIds = new Set();

            countryControls.querySelectorAll('[data-role="country-group-country"]').forEach(function (input) {
                if (input.dataset.groupId !== editingGroupId) {
                    groupedCountryIds.add(input.value);
                }
            });

            Array.from(groupCountriesSelect.options).forEach(function (option) {
                option.disabled = groupedCountryIds.has(option.value);
            });
        }

        function resetGroupEditor() {
            editingGroupId = null;
            groupNameInput.value = '';
            Array.from(groupCountriesSelect.options).forEach(function (option) {
                option.selected = false;
            });
            groupSaveButton.querySelector('span').textContent = $t('Group Countries');
            cancelGroupEditButton.style.display = 'none';
            updateGroupedCountryOptions();
        }

        function editCountryGroup(groupId) {
            const nameInput = Array.from(countryControls.querySelectorAll('[data-role="country-group-name"]'))
                .find(function (input) {
                    return input.dataset.groupId === groupId;
                });
            if (!nameInput) {
                console.error('The selected country group could not be loaded for editing.');
                return;
            }

            editingGroupId = groupId;
            groupNameInput.value = nameInput.value;
            Array.from(groupCountriesSelect.options).forEach(function (option) {
                option.selected = false;
            });
            countryControls.querySelectorAll('[data-role="country-group-country"]').forEach(function (input) {
                if (input.dataset.groupId !== groupId) {
                    return;
                }
                const option = Array.from(groupCountriesSelect.options).find(function (item) {
                    return item.value === input.value;
                });
                if (option) {
                    option.selected = true;
                }
            });
            groupSaveButton.querySelector('span').textContent = $t('Save Group');
            cancelGroupEditButton.style.display = '';
            updateGroupedCountryOptions();
            groupNameInput.focus();
        }



        function findDestination(destinationKey) {
            return Array.from(otherDestinations.querySelectorAll('[data-destination-key]'))
                .find(function (destination) {
                    return destination.dataset.destinationKey === destinationKey;
                });
        }

        function makeDestination(destinationKey, label, rateTable) {
            const detail = document.createElement('details');
            const summary = document.createElement('summary');
            const title = document.createElement('strong');

            detail.dataset.destinationKey = destinationKey;
            title.textContent = label;
            summary.appendChild(title);
            detail.appendChild(summary);
            detail.appendChild(rateTable);
            return detail;
        }

        function getRateTable(destinationKey, label) {
            const separator = destinationKey.indexOf(':');
            const scope = destinationKey.slice(0, separator);
            const destinationId = destinationKey.slice(separator + 1);
            const existingDetail = findDestination(destinationKey);
            let rateTable = existingDetail && existingDetail.querySelector('table');

            if (rateTable) {
                return {detail: existingDetail, rateTable: rateTable};
            }

            const template = scope === 'regions' ? regionTemplate
                : (scope === 'groups' ? groupTemplate : countryTemplate);
            rateTable = template.content.querySelector('table');
            if (!rateTable) {
                console.error('Country shipping rates could not be created for ' + destinationKey + '.');
                return null;
            }
            rateTable = rateTable.cloneNode(true);
            const placeholder = scope === 'regions' ? '__DESTINATION__'
                : (scope === 'groups' ? '__GROUP__' : '__COUNTRY__');
            rateTable.querySelectorAll('[name]').forEach(function (input) {
                input.name = input.name.split(placeholder).join(destinationId);
            });
            const detail = makeDestination(destinationKey, label, rateTable);
            otherDestinations.appendChild(detail);
            return {detail: detail, rateTable: rateTable};
        }

        function addCountry(destinationKey, label, baseColumn) {
            const destination = getRateTable(destinationKey, label);
            if (!destination) {
                return;
            }

            const heading = document.createElement('th');
            const cell = document.createElement('td');
            const removeButton = document.createElement('button');
            const removeLabel = document.createElement('span');

            heading.style.cssText = 'width:340px;border:1px solid #c6c6c6;padding:8px;';
            heading.dataset.countryColumn = destinationKey;
            heading.dataset.destinationKey = destinationKey;
            heading.dataset.countryLabel = label;
            if (destinationKey.startsWith('groups:')) {
                const groupId = destinationKey.slice('groups:'.length);
                const editButton = document.createElement('button');
                const editLabel = document.createElement('span');

                heading.dataset.groupId = groupId;
                heading.appendChild(document.createTextNode(label + ' '));
                editButton.type = 'button';
                editButton.className = 'action-secondary';
                editButton.dataset.action = 'edit-country-group';
                editButton.dataset.groupId = groupId;
                editLabel.textContent = $t('Edit');
                editButton.appendChild(editLabel);
                heading.appendChild(editButton);
                heading.appendChild(document.createTextNode(' '));
            } else {
                heading.appendChild(document.createTextNode(label + ' '));
            }
            removeButton.type = 'button';
            removeButton.className = 'action-secondary';
            removeButton.dataset.action = 'remove-country';
            removeButton.dataset.destinationKey = destinationKey;
            if (baseColumn) {
                removeButton.dataset.baseColumn = 'true';
            }
            removeLabel.textContent = element.dataset.removeLabel || 'Remove';
            removeButton.appendChild(removeLabel);
            heading.appendChild(removeButton);

            cell.style.cssText = 'width:340px;vertical-align:top;border:1px solid #c6c6c6;padding:8px;';
            cell.dataset.countryColumn = destinationKey;
            cell.appendChild(destination.rateTable);
            tableHead.appendChild(heading);
            tableRow.appendChild(cell);
            destination.detail.remove();

            if (destinationKey.startsWith('countries:') && !baseColumn) {
                const countryId = destinationKey.slice('countries:'.length);
                const template = countryControls.querySelector('[data-role="country-column"]');
                if (!template) {
                    console.error('Country column configuration could not be saved.');
                    return;
                }
                const columnInput = document.createElement('input');
                columnInput.type = 'hidden';
                columnInput.name = template.name;
                columnInput.value = countryId;
                columnInput.dataset.role = 'country-column';
                columnInput.dataset.countryId = countryId;
                countryControls.appendChild(columnInput);

            }
            const option = Array.from(countrySelect.options).find(function (item) {
                return item.value === destinationKey;
            });
            if (option) {
                option.hidden = true;
            }

            const hiddenInput = Array.from(countryControls.querySelectorAll(
                '[data-role="hidden-column"][data-destination-key]'
            )).find(function (input) {
                return input.dataset.destinationKey === destinationKey;
            });
            if (hiddenInput) {
                hiddenInput.remove();
            }
            updateTableWidth();
        }

        function addCountryGroup() {
            const groupName = groupNameInput.value.trim();
            const countryIds = Array.from(groupCountriesSelect.selectedOptions)
                .map(function (option) {
                    return option.value;
                })
                .sort();

            if (!groupName || countryIds.length < 2) {
                window.alert($t('Enter a group name and select at least two countries.'));
                return;
            }

            const groupId = editingGroupId || 'group_' + countryIds.join('_');
            const destinationKey = 'groups:' + groupId;
            const existingGroup = Array.from(countryControls.querySelectorAll(
                '[data-role="country-group-name"]'
            )).find(function (input) {
                return input.dataset.groupId === groupId && input.dataset.groupId !== editingGroupId;
            });
            if (existingGroup) {
                window.alert($t('These countries already belong to a group.'));
                return;
            }

            const membershipConflict = Array.from(countryControls.querySelectorAll(
                '[data-role="country-group-country"]'
            )).some(function (input) {
                return input.dataset.groupId !== editingGroupId && countryIds.includes(input.value);
            });
            if (membershipConflict) {
                window.alert($t('One or more selected countries already belong to another group.'));
                return;
            }

            const label = groupName + ' (' + countryIds.join(', ') + ')';
            let nameInput = Array.from(countryControls.querySelectorAll('[data-role="country-group-name"]'))
                .find(function (input) {
                    return input.dataset.groupId === groupId;
                });
            if (!nameInput) {
                nameInput = groupNameTemplate.content.querySelector('input').cloneNode();
                nameInput.name = nameInput.name.split('__GROUP__').join(groupId);
                nameInput.dataset.groupId = groupId;
                countryControls.appendChild(nameInput);
            }
            nameInput.value = groupName;
            countryControls.querySelectorAll(
                '[data-role="country-group-country"][data-group-id="' + groupId + '"]'
            ).forEach(function (input) {
                input.remove();
            });
            countryIds.forEach(function (countryId) {
                const countryInput = groupCountryTemplate.content.querySelector('input').cloneNode();
                countryInput.name = countryInput.name.split('__GROUP__').join(groupId);
                countryInput.value = countryId;
                countryInput.dataset.groupId = groupId;
                countryControls.appendChild(countryInput);
            });
            updateGroupedCountryOptions();

            let option = Array.from(countrySelect.options).find(function (item) {
                return item.value === destinationKey;
            });
            if (!option) {
                option = document.createElement('option');
                option.value = destinationKey;
                option.dataset.baseColumn = 'true';
                countrySelect.appendChild(option);
                addCountry(destinationKey, label, true);
            }
            option.textContent = label;
            const heading = Array.from(tableHead.querySelectorAll('th[data-group-id]'))
                .find(function (item) {
                    return item.dataset.groupId === groupId;
                });
            if (heading) {
                heading.dataset.countryLabel = label;
                if (heading.firstChild && heading.firstChild.nodeType === Node.TEXT_NODE) {
                    heading.firstChild.nodeValue = label + ' ';
                }
            }
            resetGroupEditor();
        }

        updateGroupedCountryOptions();

        element.addEventListener('click', function (event) {
            const target = event.target;
            const button = target instanceof Element ? target.closest('button[data-action]') : null;

            if (!button) {
                return;
            }

            if (button.dataset.action === 'add-country') {
                const option = countrySelect.options[countrySelect.selectedIndex];
                if (option && option.value) {
                    addCountry(option.value, option.textContent.trim(), option.dataset.baseColumn === 'true');
                    countrySelect.value = '';
                }
                return;
            }

            if (button.dataset.action === 'edit-country-group') {
                editCountryGroup(button.dataset.groupId);
                return;
            }

            if (button.dataset.action === 'group-countries') {
                addCountryGroup();
                return;
            }

            if (button.dataset.action === 'cancel-country-group') {
                resetGroupEditor();
                return;
            }

            if (button.dataset.action !== 'remove-country') {
                return;
            }

            const destinationKey = button.dataset.destinationKey;
            const heading = button.closest('th[data-destination-key]');
            const cell = Array.from(tableRow.querySelectorAll('td[data-country-column]'))
                .find(function (item) {
                    return item.dataset.countryColumn === destinationKey;
                });

            if (!destinationKey || !heading || !cell) {
                console.error('The selected country column could not be removed.');
                return;
            }
            const rateTable = cell.querySelector('table');
            if (!rateTable) {
                console.error('The selected country rates could not be restored.');
                return;
            }

            if (destinationKey.startsWith('groups:')) {
                if (!window.confirm($t(
                    'Removing this group will delete its shipping rates and release its countries. Continue?'
                ))) {
                    return;
                }

                const groupId = destinationKey.slice('groups:'.length);
                if (editingGroupId === groupId) {
                    resetGroupEditor();
                }
                countryControls.querySelectorAll(
                    '[data-role="country-group-country"][data-group-id="' + groupId + '"]'
                ).forEach(function (input) {
                    input.remove();
                });
                countryControls.querySelectorAll(
                    '[data-group-id="' + groupId + '"]'
                ).forEach(function (input) {
                    input.remove();
                });
                rateTable.querySelectorAll('[name]').forEach(function (input) {
                    input.remove();
                });
                updateGroupedCountryOptions();

                const groupOption = Array.from(countrySelect.options).find(function (item) {
                    return item.value === destinationKey;
                });
                if (groupOption) {
                    groupOption.remove();
                }
                heading.remove();
                cell.remove();
                updateTableWidth();
                return;
            }

            const detail = makeDestination(
                destinationKey,
                heading.dataset.countryLabel || destinationKey,
                rateTable
            );
            otherDestinations.appendChild(detail);

            const countryId = destinationKey.startsWith('countries:')
                ? destinationKey.slice('countries:'.length)
                : null;
            if (button.dataset.baseColumn === 'true') {
                const template = countryControls.querySelector('[data-role="hidden-column"]');
                if (!template) {
                    console.error('Country column configuration could not be saved.');
                    return;
                }
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = template.name;
                hiddenInput.value = destinationKey;
                hiddenInput.dataset.role = 'hidden-column';
                hiddenInput.dataset.destinationKey = destinationKey;
                countryControls.appendChild(hiddenInput);
            } else if (countryId) {
                const columnInput = Array.from(countryControls.querySelectorAll(
                    '[data-role="country-column"][data-country-id]'
                )).find(function (input) {
                    return input.dataset.countryId === countryId;
                });
                if (columnInput) {
                    columnInput.remove();
                }
            }

            heading.remove();
            cell.remove();
            const option = Array.from(countrySelect.options).find(function (item) {
                return item.value === destinationKey;
            });
            if (option) {
                option.hidden = false;
            }
            updateTableWidth();
        });
    };
});
