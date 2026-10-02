define(['prototype'], function () {
    'use strict';

    var prototypeElement = window.Element;

    if (!window.Prototype || !prototypeElement || typeof prototypeElement.extend !== 'function') {
        console.error('Magento Prototype element helpers are unavailable on the system configuration page.');
        return;
    }

    window.$ = function (element) {
        var elements = [],
            index;

        if (arguments.length > 1) {
            for (index = 0; index < arguments.length; index++) {
                elements.push(window.$(arguments[index]));
            }

            return elements;
        }

        if (typeof element === 'string') {
            element = document.getElementById(element);
        }

        return prototypeElement.extend(element);
    };
});
