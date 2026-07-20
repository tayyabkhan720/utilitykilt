/**
 * Copyright © Ops. All rights reserved.
 */
define([
    'jquery',
    'domReady!'
], function ($) {
    'use strict';

    return function (config, element) {
        var $faqSection = $(element);
        if (!$faqSection.length) {
            $faqSection = $('.category-faq-section');
        }
        
        if (!$faqSection.length) {
            return;
        }
        
        // Initialize FAQ functionality
        function initializeFaq() {
            // Function to update icons based on active state
            function updateIcons($item) {
                var $plusIcon = $item.find('.category-faq-icon-plus');
                var $minusIcon = $item.find('.category-faq-icon-minus');
                var isActive = $item.hasClass('active');
                
                if (isActive) {
                    // Show minus, hide plus
                    $plusIcon.css({
                        'display': 'none',
                        'visibility': 'hidden'
                    });
                    $minusIcon.css({
                        'display': 'inline-flex',
                        'visibility': 'visible'
                    });
                } else {
                    // Show plus, hide minus
                    $plusIcon.css({
                        'display': 'inline-flex',
                        'visibility': 'visible'
                    });
                    $minusIcon.css({
                        'display': 'none',
                        'visibility': 'hidden'
                    });
                }
            }

            // Initialize all FAQ items - ensure all start collapsed
            $faqSection.find('.category-faq-item').each(function() {
                var $item = $(this);
                var $button = $item.find('.category-faq-question');
                // Remove active class to ensure all start collapsed
                $item.removeClass('active');
                $button.attr('aria-expanded', 'false');
                // Update icons to show plus (collapsed state)
                updateIcons($item);
            });

            // Toggle FAQ item on click
            $faqSection.on('click', '.category-faq-question', function (e) {
                e.preventDefault();
                e.stopPropagation();
                
                var $item = $(this).closest('.category-faq-item');
                var $button = $(this);
                var isActive = $item.hasClass('active');

                if (isActive) {
                    // Collapse - remove active class
                    $item.removeClass('active');
                    $button.attr('aria-expanded', 'false');
                    updateIcons($item);
                } else {
                    // Expand - close all others first (accordion behavior)
                    $faqSection.find('.category-faq-item').not($item).each(function() {
                        var $otherItem = $(this);
                        if ($otherItem.hasClass('active')) {
                            $otherItem.removeClass('active');
                            $otherItem.find('.category-faq-question').attr('aria-expanded', 'false');
                            updateIcons($otherItem);
                        }
                    });
                    
                    // Add active class to current item
                    $item.addClass('active');
                    $button.attr('aria-expanded', 'true');
                    updateIcons($item);
                }
            });
        }
        
        // Initialize immediately
        initializeFaq();
    };
});
