(function () {
  'use strict';

  const categoryMethodCode = 'tjv_category_category';

  function fetchTotalsWithResolvedMethod() {
    if (this.abortTotalsController) {
      this.abortTotalsController.abort();
    }
    this.$dispatch('update-totals-start', {});

    const selectedRate = this.availableShippingMethods.find(
      (rate) =>
        `${rate.carrier_code}_${rate.method_code}` === this.shippingMethod
    );
    let carrierCode = selectedRate ? selectedRate.carrier_code : null;
    let methodCode = selectedRate ? selectedRate.method_code : null;

    if (!selectedRate && this.shippingMethod) {
      const separatorIndex = this.shippingMethod.indexOf('_');
      if (separatorIndex !== -1) {
        carrierCode = this.shippingMethod.slice(0, separatorIndex);
        methodCode = this.shippingMethod.slice(separatorIndex + 1);
      }
    }

    const path = this.customer && this.customer.fullname
      ? '/V1/carts/mine/totals-information'
      : `/V1/guest-carts/${this.cart.cartId}/totals-information`;
    this.abortTotalsController = new AbortController();

    fetch(
      `${BASE_URL}rest/${CURRENT_STORE_CODE}${path}?form_key=${hyva.getFormKey()}`,
      {
        signal: this.abortTotalsController.signal,
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          addressInformation: {
            shipping_carrier_code: carrierCode,
            shipping_method_code: methodCode,
            address: this.cartData.address,
          },
        }),
      }
    )
      .then((response) => response.json())
      .then((result) => {
        if (window.checkoutConfig && window.checkoutConfig.totalsData) {
          const configuredTotals =
            window.checkoutConfig.totalsData.total_segments || [];
          result.total_segments.forEach((total) => {
            const configuredTotal = configuredTotals.find(
              (entry) => entry.code === total.code
            );
            if (configuredTotal) {
              total.title = configuredTotal.title;
            }
          });
        }

        return result;
      })
      .then((result) => {
        this.$dispatch('update-totals', { data: result });
      })
      .catch(this.displayError)
      .finally(() => {
        this.$dispatch('update-totals-end', {});
      });
  }

  function wrapShippingEstimatorData() {
    const registerData = Alpine.data.bind(Alpine);
    Alpine.data = (name, callback) => {
      if (name !== 'initShippingEstimation') {
        return registerData(name, callback);
      }

      return registerData(name, function (...args) {
        const data = callback.apply(this, args);
        data.fetchTotals = fetchTotalsWithResolvedMethod;
        return data;
      });
    };
  }

  function enforceCategoryShippingMethod() {
    document
      .querySelectorAll('[role="radiogroup"]')
      .forEach((radioGroup) => {
        const radios = Array.from(
          radioGroup.querySelectorAll('input[type="radio"]')
        );
        const requiredMethod = radios.find(
          (radio) => radio.value === categoryMethodCode
        );

        if (!requiredMethod) {
          return;
        }

        radios.forEach((radio) => {
          radio.disabled = radio !== requiredMethod;
        });

        if (!requiredMethod.checked) {
          requiredMethod.checked = true;
          requiredMethod.dispatchEvent(
            new Event('change', { bubbles: true })
          );
        }
      });
  }

  function observeShippingMethods() {
    enforceCategoryShippingMethod();
    new MutationObserver(enforceCategoryShippingMethod).observe(
      document.body,
      { childList: true, subtree: true }
    );
  }

  window.addEventListener('alpine:init', wrapShippingEstimatorData, {
    once: true,
  });

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', observeShippingMethods, {
      once: true,
    });
  } else {
    observeShippingMethods();
  }
})();
