/**
 * Copyright © Ops. All rights reserved.
 */
define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('ops.measuringGuide', {
        options: {
            modalSelector: '#measuring-guide-modal',
            closeSelector: '#measuring-guide-close',
            overlaySelector: '.measuring-guide-modal-overlay'
        },

        /**
         * Initialize widget
         */
        _create: function () {
            this._bind();
        },

        /**
         * Bind events
         */
        _bind: function () {
            var self = this;

            // Open modal on button click
            this.element.on('click', function (e) {
                e.preventDefault();
                self._openModal();
            });

            // Close modal on close button click
            $(this.options.closeSelector).on('click', function (e) {
                e.preventDefault();
                self._closeModal();
            });

            // Close modal on overlay click
            $(this.options.overlaySelector).on('click', function (e) {
                if (e.target === this) {
                    self._closeModal();
                }
            });

            // Close modal on ESC key
            $(document).on('keydown.measuringGuide', function (e) {
                if (e.keyCode === 27) { // ESC key
                    self._closeModal();
                }
            });
        },

        /**
         * Open modal
         */
        _openModal: function () {
            var $modal = $(this.options.modalSelector);
            $modal.css('display', 'flex').addClass('measuring-guide-modal-open');
            $('body').addClass('measuring-guide-modal-open');
        },

        /**
         * Close modal
         */
        _closeModal: function () {
            var $modal = $(this.options.modalSelector);
            $modal.css('display', 'none').removeClass('measuring-guide-modal-open');
            $('body').removeClass('measuring-guide-modal-open');
        }
    });

    return $.ops.measuringGuide;
});

