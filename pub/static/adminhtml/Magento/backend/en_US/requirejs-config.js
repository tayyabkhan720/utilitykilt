(function(require){
(function() {
/**
 * Copyright 2024 Adobe
 * All Rights Reserved.
 */

var config = {
    map: {
        '*': {
            'nonceInjector': 'Magento_Csp/js/nonce-injector'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config: {
        mixins: {
            'Magento_ReleaseNotification/js/modal/component': {
                'Magento_AdminAnalytics/js/release-notification/modal/component-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            systemMessageDialog: 'Magento_AdminNotification/system/notification',
            toolbarEntry:   'Magento_AdminNotification/toolbar_entry'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    waitSeconds: 0,
    map: {
        '*': {
            'ko': 'knockoutjs/knockout',
            'knockout': 'knockoutjs/knockout',
            'mageUtils': 'mage/utils/main',
            'rjsResolver': 'mage/requirejs/resolver',
            'jquery-ui-modules/core': 'jquery/ui-modules/core',
            'jquery-ui-modules/accordion': 'jquery/ui-modules/widgets/accordion',
            'jquery-ui-modules/autocomplete': 'jquery/ui-modules/widgets/autocomplete',
            'jquery-ui-modules/button': 'jquery/ui-modules/widgets/button',
            'jquery-ui-modules/datepicker': 'jquery/ui-modules/widgets/datepicker',
            'jquery-ui-modules/dialog': 'jquery/ui-modules/widgets/dialog',
            'jquery-ui-modules/draggable': 'jquery/ui-modules/widgets/draggable',
            'jquery-ui-modules/droppable': 'jquery/ui-modules/widgets/droppable',
            'jquery-ui-modules/effect-blind': 'jquery/ui-modules/effects/effect-blind',
            'jquery-ui-modules/effect-bounce': 'jquery/ui-modules/effects/effect-bounce',
            'jquery-ui-modules/effect-clip': 'jquery/ui-modules/effects/effect-clip',
            'jquery-ui-modules/effect-drop': 'jquery/ui-modules/effects/effect-drop',
            'jquery-ui-modules/effect-explode': 'jquery/ui-modules/effects/effect-explode',
            'jquery-ui-modules/effect-fade': 'jquery/ui-modules/effects/effect-fade',
            'jquery-ui-modules/effect-fold': 'jquery/ui-modules/effects/effect-fold',
            'jquery-ui-modules/effect-highlight': 'jquery/ui-modules/effects/effect-highlight',
            'jquery-ui-modules/effect-scale': 'jquery/ui-modules/effects/effect-scale',
            'jquery-ui-modules/effect-pulsate': 'jquery/ui-modules/effects/effect-pulsate',
            'jquery-ui-modules/effect-shake': 'jquery/ui-modules/effects/effect-shake',
            'jquery-ui-modules/effect-slide': 'jquery/ui-modules/effects/effect-slide',
            'jquery-ui-modules/effect-transfer': 'jquery/ui-modules/effects/effect-transfer',
            'jquery-ui-modules/effect': 'jquery/ui-modules/effect',
            'jquery-ui-modules/menu': 'jquery/ui-modules/widgets/menu',
            'jquery-ui-modules/mouse': 'jquery/ui-modules/widgets/mouse',
            'jquery-ui-modules/position': 'jquery/ui-modules/position',
            'jquery-ui-modules/progressbar': 'jquery/ui-modules/widgets/progressbar',
            'jquery-ui-modules/resizable': 'jquery/ui-modules/widgets/resizable',
            'jquery-ui-modules/selectable': 'jquery/ui-modules/widgets/selectable',
            'jquery-ui-modules/selectmenu': 'jquery/ui-modules/widgets/selectmenu',
            'jquery-ui-modules/slider': 'jquery/ui-modules/widgets/slider',
            'jquery-ui-modules/sortable': 'jquery/ui-modules/widgets/sortable',
            'jquery-ui-modules/spinner': 'jquery/ui-modules/widgets/spinner',
            'jquery-ui-modules/tabs': 'jquery/ui-modules/widgets/tabs',
            'jquery-ui-modules/tooltip': 'jquery/ui-modules/widgets/tooltip',
            'jquery-ui-modules/widget': 'jquery/ui-modules/widget',
            'jquery-ui-modules/timepicker': 'jquery/timepicker',
            'vimeo': 'vimeo/player',
            'vimeoWrapper': 'vimeo/vimeo-wrapper'
        }
    },
    shim: {
        'mage/adminhtml/backup': ['prototype'],
        'mage/captcha': ['prototype'],
        'mage/new-gallery': ['jquery'],
        'jquery/ui': ['jquery'],
        'matchMedia': {
            'exports': 'mediaCheck'
        },
        'magnifier/magnifier': ['jquery'],
        'vimeo/player': {
            'exports': 'Player'
        }
    },
    paths: {
        'jquery/validate': 'jquery/jquery.validate',
        'jquery/uppy-core': 'jquery/uppy/dist/uppy.min',
        'prototype': 'legacy-build.min',
        'jquery/jquery-storageapi': 'js-storage/storage-wrapper',
        'text': 'mage/requirejs/text',
        'domReady': 'requirejs/domReady',
        'spectrum': 'jquery/spectrum/spectrum',
        'tinycolor': 'jquery/spectrum/tinycolor',
        'jquery-ui-modules': 'jquery/ui-modules'
    },
    config: {
        text: {
            'headers': {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    }
};

require(['jquery'], function ($) {
    'use strict';

    $.noConflict();
});

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    'shim': {
        'jquery/editableMultiselect/js/jquery.editable': [
            'jquery'
        ]
    },
    'bundles': {
        'js/theme': [
            'globalNavigation',
            'globalSearch',
            'modalPopup',
            'useDefault',
            'loadingPopup',
            'collapsable'
        ]
    },
    'map': {
        '*': {
            'translateInline':                    'mage/translate-inline',
            'form':                               'mage/backend/form',
            'button':                             'mage/backend/button',
            'accordion':                          'mage/accordion',
            'actionLink':                         'mage/backend/action-link',
            'validation':                         'mage/backend/validation',
            'notification':                       'mage/backend/notification',
            'loader':                             'mage/loader_old',
            'loaderAjax':                         'mage/loader_old',
            'floatingHeader':                     'mage/backend/floating-header',
            'suggest':                            'mage/backend/suggest',
            'mediabrowser':                       'jquery/jstree/jquery.jstree',
            'tabs':                               'mage/backend/tabs',
            'treeSuggest':                        'mage/backend/tree-suggest',
            'calendar':                           'mage/calendar',
            'dropdown':                           'mage/dropdown_old',
            'collapsible':                        'mage/collapsible',
            'menu':                               'mage/backend/menu',
            'jstree':                             'jquery/jstree/jquery.jstree',
            'jquery-ui-modules/widget':           'jquery/ui',
            'jquery-ui-modules/core':             'jquery/ui',
            'jquery-ui-modules/accordion':        'jquery/ui',
            'jquery-ui-modules/autocomplete':     'jquery/ui',
            'jquery-ui-modules/button':           'jquery/ui',
            'jquery-ui-modules/datepicker':       'jquery/ui',
            'jquery-ui-modules/dialog':           'jquery/ui',
            'jquery-ui-modules/draggable':        'jquery/ui',
            'jquery-ui-modules/droppable':        'jquery/ui',
            'jquery-ui-modules/effect-blind':     'jquery/ui',
            'jquery-ui-modules/effect-bounce':    'jquery/ui',
            'jquery-ui-modules/effect-clip':      'jquery/ui',
            'jquery-ui-modules/effect-drop':      'jquery/ui',
            'jquery-ui-modules/effect-explode':   'jquery/ui',
            'jquery-ui-modules/effect-fade':      'jquery/ui',
            'jquery-ui-modules/effect-fold':      'jquery/ui',
            'jquery-ui-modules/effect-highlight': 'jquery/ui',
            'jquery-ui-modules/effect-scale':     'jquery/ui',
            'jquery-ui-modules/effect-pulsate':   'jquery/ui',
            'jquery-ui-modules/effect-shake':     'jquery/ui',
            'jquery-ui-modules/effect-slide':     'jquery/ui',
            'jquery-ui-modules/effect-transfer':  'jquery/ui',
            'jquery-ui-modules/effect':           'jquery/ui',
            'jquery-ui-modules/menu':             'jquery/ui',
            'jquery-ui-modules/mouse':            'jquery/ui',
            'jquery-ui-modules/position':         'jquery/ui',
            'jquery-ui-modules/progressbar':      'jquery/ui',
            'jquery-ui-modules/resizable':        'jquery/ui',
            'jquery-ui-modules/selectable':       'jquery/ui',
            'jquery-ui-modules/slider':           'jquery/ui',
            'jquery-ui-modules/sortable':         'jquery/ui',
            'jquery-ui-modules/spinner':          'jquery/ui',
            'jquery-ui-modules/tabs':             'jquery/ui',
            'jquery-ui-modules/tooltip':          'jquery/ui'
        }
    },
    'deps': [
        'js/theme',
        'mage/backend/bootstrap',
        'mage/adminhtml/globals'
    ],
    'paths': {
        'jquery/ui': 'jquery/jquery-ui'
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            'mediaUploader':  'Magento_Backend/js/media-uploader'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            escaper: 'Magento_Security/js/escaper'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            popupWindow:            'mage/popup-window',
            confirmRedirect:        'Magento_Security/js/confirm-redirect'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            rolesTree: 'Magento_User/js/roles-tree',
            deleteUserAccount: 'Magento_User/js/delete-user-account'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            eavInputTypes: 'Magento_Eav/js/input-types'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    paths: {
        'customer/template': 'Magento_Customer/templates'
    }
};

require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            loadIcons: 'Magento_AdminAdobeIms/js/loadicons',
            adobeImsReauth: 'Magento_AdminAdobeIms/js/adobe-ims-reauth'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            folderTree: 'Magento_Cms/js/folder-tree'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            integration: 'Magento_Integration/js/integration'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            priceBox:             'Magento_Catalog/js/price-box',
            priceOptionDate:      'Magento_Catalog/js/price-option-date',
            priceOptionFile:      'Magento_Catalog/js/price-option-file',
            priceOptions:         'Magento_Catalog/js/price-options',
            priceUtils:           'Magento_Catalog/js/price-utils'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            categoryForm:         'Magento_Catalog/catalog/category/form',
            newCategoryDialog:    'Magento_Catalog/js/new-category-dialog',
            categoryTree:         'Magento_Catalog/js/category-tree',
            productGallery:       'Magento_Catalog/js/product-gallery',
            baseImage:            'Magento_Catalog/catalog/base-image-uploader',
            productAttributes:    'Magento_Catalog/catalog/product-attributes',
            categoryCheckboxTree: 'Magento_Catalog/js/category-checkbox-tree'
        }
    },
    deps: [
        'Magento_Catalog/catalog/product'
    ],
    config: {
        mixins: {
            'Magento_Catalog/js/components/use-parent-settings/select': {
                'Magento_Catalog/js/components/use-parent-settings/toggle-disabled-mixin': true
            },
            'Magento_Catalog/js/components/use-parent-settings/textarea': {
                'Magento_Catalog/js/components/use-parent-settings/toggle-disabled-mixin': true
            },
            'Magento_Catalog/js/components/use-parent-settings/single-checkbox': {
                'Magento_Catalog/js/components/use-parent-settings/toggle-disabled-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            orderEditDialog: 'Magento_Sales/order/edit/message'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            testConnection: 'Magento_AdvancedSearch/js/testconnection'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    deps: [],
    shim: {
        'chartjs/chartjs-adapter-moment': ['moment'],
        'chartjs/es6-shim.min': {},
        'hugerte/hugerte.min': {
            exports: 'hugerte',
            init: function () {
                'use strict';
                window.tinymce = window.hugerte;
                window.tinyMCE = window.hugerte;
                return window.hugerte;
            }
        }
    },
    paths: {
        'ui/template': 'Magento_Ui/templates'
    },
    map: {
        '*': {
            uiElement:      'Magento_Ui/js/lib/core/element/element',
            uiCollection:   'Magento_Ui/js/lib/core/collection',
            uiComponent:    'Magento_Ui/js/lib/core/collection',
            uiClass:        'Magento_Ui/js/lib/core/class',
            uiEvents:       'Magento_Ui/js/lib/core/events',
            uiRegistry:     'Magento_Ui/js/lib/registry/registry',
            consoleLogger:  'Magento_Ui/js/lib/logger/console-logger',
            uiLayout:       'Magento_Ui/js/core/renderer/layout',
            buttonAdapter:  'Magento_Ui/js/form/button-adapter',
            chartJs:        'chartjs/Chart.min',
            'chart.js':     'chartjs/Chart.min',
            tinymce:        'hugerte/hugerte.min',
            wysiwygAdapter: 'mage/adminhtml/wysiwyg/tiny_mce/tinymceAdapter'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            groupedProduct: 'Magento_GroupedProduct/js/grouped-product'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            'slick': 'Magento_PageBuilder/js/resource/slick/slick',
            'jarallax': 'Magento_PageBuilder/js/resource/jarallax/jarallax',
            'jarallaxVideo': 'Magento_PageBuilder/js/resource/jarallax/jarallax-video',
            'Magento_PageBuilder/js/resource/vimeo/player': 'vimeo/player',
            'Magento_PageBuilder/js/resource/vimeo/vimeo-wrapper': 'vimeo/vimeo-wrapper',
            'jarallax-wrapper': 'Magento_PageBuilder/js/resource/jarallax/jarallax-wrapper'
        }
    },
    shim: {
        'Magento_PageBuilder/js/resource/slick/slick': {
            deps: ['jquery']
        },
        'Magento_PageBuilder/js/resource/jarallax/jarallax-video': {
            deps: ['jarallax-wrapper', 'vimeoWrapper']
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            /* Include our Knockout Sortable wrapper */
            'pagebuilder/ko-dropzone': 'Magento_PageBuilder/js/resource/dropzone/knockout-dropzone',

            /* Utilities */
            'google-map': 'Magento_PageBuilder/js/utils/map',
            'object-path': 'Magento_PageBuilder/js/resource/object-path',
            'html2canvas': 'Magento_PageBuilder/js/resource/html2canvas/html2canvas.min',
            'csso': 'Magento_PageBuilder/js/resource/csso/csso'
        }
    },
    shim: {
        'pagebuilder/ko-sortable': {
            deps: ['jquery', 'jquery/ui', 'Magento_PageBuilder/js/resource/jquery-ui/jquery.ui.touch-punch']
        },
        'Magento_PageBuilder/js/resource/jquery/ui/jquery.ui.touch-punch': {
            deps: ['jquery/ui']
        }
    },
    config: {
        mixins: {
            'Magento_Ui/js/form/element/abstract': {
                'Magento_PageBuilder/js/form/element/conditional-disable-mixin': true,
                'Magento_PageBuilder/js/form/element/dependent-value-mixin': true
            },
            'Magento_Ui/js/lib/validation/validator': {
                'Magento_PageBuilder/js/form/element/validator-rules-mixin': true
            },
            'mage/validation': {
                'Magento_PageBuilder/js/system/config/validator-rules-mixin': true
            },
            'Magento_Ui/js/form/form': {
                'Magento_PageBuilder/js/form/form-mixin': true
            },
            'Magento_PageBuilder/js/content-type/row/appearance/default/widget': {
                'Magento_PageBuilder/js/content-type/row/appearance/default/widget-mixin': true
            },
            'Magento_Ui/js/form/element/file-uploader': {
                'Magento_PageBuilder/js/form/element/file-uploader': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            transparent: 'Magento_Payment/js/transparent',
            'Magento_Payment/transparent': 'Magento_Payment/js/transparent'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            newVideoDialog:  'Magento_ProductVideo/js/new-video-dialog',
            openVideoModal:  'Magento_ProductVideo/js/video-modal'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config: {
        mixins: {
            'Magento_ConfigurableProduct/js/components/dynamic-rows-configurable': {
                'Magento_InventoryConfigurableProductAdminUi/js/dynamic-rows-configurable-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config: {
        mixins: {
            'Magento_PageBuilder/js/events': {
                'Magento_PageBuilderAdminAnalytics/js/page-builder/events-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            scriptLoader: 'Magento_PaymentServicesPaypal/js/lib/script-loader-wrapper',
            paymentSdkLoader: 'Magento_PaymentServicesPaypal/js/lib/payment-sdk-loader',
        }
    },
    shim: {
        'Magento_PaymentServicesPaypal/js/lib/script-loader': {
            init: function () {
                'use strict';

                return {
                    load: window.paypalLoadScript,
                    loadCustom: window.paypalLoadCustomScript
                };
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * ADOBE CONFIDENTIAL
 *
 * Copyright 2025 Adobe
 * All Rights Reserved.
 *
 * NOTICE: All information contained herein is, and remains
 * the property of Adobe and its suppliers, if any. The intellectual
 * and technical concepts contained herein are proprietary to Adobe
 * and its suppliers and are protected by all applicable intellectual
 * property laws, including trade secret and copyright laws.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from Adobe.
 */

var config = {
    paths: {
        'paypalMessageConfigurator': 'https://www.paypalobjects.com/merchant-library/merchant-configurator'
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config: {
        map: {
            '*': {
                triggerShippingMethodUpdate: 'Magento_InventoryInStorePickupSalesAdminUi/order/create/trigger-shipping-method-update' //eslint-disable-line max-len
            }
        },
        mixins: {
            'Magento_Sales/order/create/scripts': {
                'Magento_InventoryInStorePickupSalesAdminUi/order/create/scripts-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            swatchesProductAttributes: 'Magento_Swatches/js/product-attributes'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            mageTranslationDictionary: 'Magento_Translation/js/mage-translation-dictionary'
        }
    },
    deps: [
        'mageTranslationDictionary'
    ]
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            fptAttribute: 'Magento_Weee/js/fpt-attribute'
        }
    }
};

require.config(config);
})();
(function() {
var config = {
    config: {
        mixins: {
            'js/theme': {
                'Amasty_Base/js/theme': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Config to pull in all the relevant Braintree JS SDKs
 * @type {
 *  paths: {
 *      braintreePayPalInContextCheckout: string,
 *      braintreePayPalCheckout: string,
 *      braintreeVenmo: string,
 *      braintreeHostedFields: string,
 *      braintreeDataCollector: string,
 *      braintreeThreeDSecure: string,
 *      braintreeGooglePay: string,
 *      braintreeApplePay: string,
 *      braintreeAch: string,
 *      braintreeLpm: string,
 *      googlePayLibrary: string
 * },
 *  map: {
 *      "*": {
 *          braintree: string
 *      }
 *  }
 * }
 */
var config = {
    map: {
        '*': {
            braintree: 'https://js.braintreegateway.com/web/3.112.0/js/client.min.js'
        }
    },

    paths: {
        'braintreePayPalCheckout': 'https://js.braintreegateway.com/web/3.112.0/js/paypal-checkout.min',
        'braintreeHostedFields': 'https://js.braintreegateway.com/web/3.112.0/js/hosted-fields.min',
        'braintreeDataCollector': 'https://js.braintreegateway.com/web/3.112.0/js/data-collector.min',
        'braintreeThreeDSecure': 'https://js.braintreegateway.com/web/3.112.0/js/three-d-secure.min',
        'braintreeApplePay': 'https://js.braintreegateway.com/web/3.112.0/js/apple-pay.min',
        'braintreeGooglePay': 'https://js.braintreegateway.com/web/3.112.0/js/google-payment.min',
        'braintreeVenmo': 'https://js.braintreegateway.com/web/3.112.0/js/venmo.min',
        'braintreeAch': 'https://js.braintreegateway.com/web/3.112.0/js/us-bank-account.min',
        'braintreeLpm': 'https://js.braintreegateway.com/web/3.112.0/js/local-payment.min',
        'googlePayLibrary': 'https://pay.google.com/gp/p/js/pay',
        'braintreePayPalInContextCheckout': 'https://www.paypalobjects.com/api/checkout'
    }
};

require.config(config);
})();
(function() {
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes. All rights reserved.
 * See COPYING.txt for license details.
 */
var config = {
    config: {
        mixins: {
            'Magento_Ui/js/lib/validation/validator': {
                'Hyva_Theme/js/form/element/validator-rules-mixin': true
            },
        }
    }
}

require.config(config);
})();
(function() {

var config = {
    config: {
        mixins: {
            'Magento_Ui/js/lib/validation/validator': {
                'Hyva_PageBuilder/js/form/element/validator-rules-mixin': true
            },
        }
    }
}

require.config(config);
})();
(function() {
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            optionBase: 'MageWorx_OptionBase/js/catalog/product/base',
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            "Magento_Ui/js/dynamic-rows/dynamic-rows": 'MageWorx_OptionBase/js/dynamic-rows',
            "MageWorx_OptionBase/dynamicRows22x": 'MageWorx_OptionBase/js/dynamic-rows-22x',
            "Magento_Catalog/js/components/dynamic-rows-import-custom-options": 'MageWorx_OptionBase/js/dynamic-rows-import-custom-options',
            "Magento_Ui/js/form/client": 'MageWorx_OptionBase/js/client'
        }
    }
};

require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            'mw-review-modal': 'MageWorx_Info/js/mw-review-modal'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            optionAdvancedPricing: 'MageWorx_OptionAdvancedPricing/js/advanced-pricing'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            dynamicOptions: 'MageWorx_DynamicOptionsBase/js/dynamicOptions',
            dynamicOptionsDefaultCalculator: 'MageWorx_DynamicOptionsBase/js/calculator/default',
            dynamicOptionMinValueValidationRule: 'MageWorx_DynamicOptionsBase/js/validation/dynamicOptionMinValueValidationRule',
            dynamicOptionMaxValueValidationRule: 'MageWorx_DynamicOptionsBase/js/validation/dynamicOptionMaxValueValidationRule',
            dynamicOptionStepValidationRule: 'MageWorx_DynamicOptionsBase/js/validation/dynamicOptionStepValidationRule'
        }
    }
};


require.config(config);
})();
(function() {
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            optionDependency: 'MageWorx_OptionDependency/js/dependency'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            optionFeatures: 'MageWorx_OptionFeatures/js/catalog/product/features',
            optionFeaturesIsDefault: 'MageWorx_OptionFeatures/js/catalog/product/isDefault',
            selectionLimitValidationRule: 'MageWorx_OptionFeatures/js/selectionLimitValidationRule',
            qTip: 'MageWorx_OptionFeatures/js/jquery.qtip',
            qTipWrapper: 'MageWorx_OptionFeatures/js/qTipWrapper'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            mageworxProductGallery: 'MageWorx_OptionFeatures/js/product-gallery',
            mageworxColorPicker: 'MageWorx_OptionFeatures/js/color-picker'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © 2016 MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            optionSwatches: 'MageWorx_OptionSwatches/js/swatches'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Core
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

var config = {
    paths: {
        'jquery/file-uploader': 'Mageplaza_Core/lib/fileUploader/jquery.fileuploader',
        'mageplaza/core/jquery/popup': 'Mageplaza_Core/js/jquery.magnific-popup.min',
        'mageplaza/core/owl.carousel': 'Mageplaza_Core/js/owl.carousel.min',
        'mageplaza/core/bootstrap': 'Mageplaza_Core/js/bootstrap.min',
        mpIonRangeSlider: 'Mageplaza_Core/js/ion.rangeSlider.min',
        touchPunch: 'Mageplaza_Core/js/jquery.ui.touch-punch.min',
        mpDevbridgeAutocomplete: 'Mageplaza_Core/js/jquery.autocomplete.min'
    },
    shim: {
        "mageplaza/core/jquery/popup": ["jquery"],
        "mageplaza/core/owl.carousel": ["jquery"],
        "mageplaza/core/bootstrap": ["jquery"],
        mpIonRangeSlider: ["jquery"],
        mpDevbridgeAutocomplete: ["jquery"],
        touchPunch: ['jquery', 'jquery-ui-modules/widget', 'jquery-ui-modules/mouse']
    }
};

require.config(config);
})();
(function() {
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Smtp
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */
var config = {
    paths: {
        'mageplaza/testemail': 'Mageplaza_Smtp/js/testemail',
        'mageplaza/provider': 'Mageplaza_Smtp/js/provider'
    }
};

require.config(config);
})();
(function() {
/* jshint browser:true jquery:true */
/* global alert */
var config = {
    map: {
        '*': {
            amastySectionsRate: 'Amasty_CheckoutCore/js/reports/sections-rate',
            amCharts: 'Amasty_CheckoutCore/vendor/amcharts/amcharts',
            amChartsSerial: 'Amasty_CheckoutCore/vendor/amcharts/serial'
        }
    },
    shim: {
        'Amasty_CheckoutCore/vendor/amcharts/serial': [ 'Amasty_CheckoutCore/vendor/amcharts/amcharts' ]
    }
};

require.config(config);
})();
(function() {
/*jshint browser:true jquery:true*/
/*global alert*/
var config = {
    map: {
        '*': {
            'stripejs': 'https://js.stripe.com/dahlia/stripe.js',
            'stripe_payments': 'StripeIntegration_Payments/js/stripe_payments'
        }
    }
};

require.config(config);
})();



})(require);