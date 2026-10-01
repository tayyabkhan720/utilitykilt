import React from 'react';
import { object } from 'prop-types';

import RadioInput from '../../common/Form/RadioInput';
import { __ } from '../../../i18n';
import { _objToArray } from '../../../utils';
import { CATEGORY_SHIPPING_METHOD_ID, SHIPPING_METHOD } from '../../../config';
import useShippingMethodFormContext from '../hooks/useShippingMethodFormContext';
import useShippingMethodCartContext from '../hooks/useShippingMethodCartContext';

function ShippingMethodList({ methodRenderers }) {
  const {
    fields,
    submitHandler,
    setFieldValue,
    selectedMethod,
    setFieldTouched,
  } = useShippingMethodFormContext();
  const { methodList } = useShippingMethodCartContext();
  const { carrierCode: methodCarrierCode, methodCode: methodMethodCode } =
    selectedMethod || {};
  const selectedMethodId = `${methodCarrierCode}__${methodMethodCode}`;
  const hasRequiredCategoryMethod = Boolean(
    methodList[CATEGORY_SHIPPING_METHOD_ID]
  );

  const handleShippingMethodSelection = async (event) => {
    const selectedMethodValue = event.target.value;
    if (
      hasRequiredCategoryMethod &&
      selectedMethodValue !== CATEGORY_SHIPPING_METHOD_ID
    ) {
      return;
    }

    const methodSelected = methodList[selectedMethodValue];
    if (!methodSelected) {
      return;
    }
    const { carrierCode, methodCode, id: methodId } = methodSelected;

    if (methodId === selectedMethodId) {
      return;
    }

    setFieldValue(SHIPPING_METHOD, { carrierCode, methodCode });
    setFieldTouched(fields.carrierCode, true);
    setFieldTouched(fields.methodCode, true);
    await submitHandler({ carrierCode, methodCode });
  };
  return (
    <div className="py-4">
      <ul>
        {_objToArray(methodList).map((method) => {
          const { id: methodId, carrierTitle, methodTitle, price } = method;
          const methodName = `${carrierTitle} (${methodTitle}): `;
          const MethodRenderer = methodRenderers[methodId];

          return (
            <li key={methodId} className="flex">
              {MethodRenderer ? (
                <MethodRenderer
                  method={method}
                  selected={selectedMethod}
                  disabled={
                    hasRequiredCategoryMethod &&
                    methodId !== CATEGORY_SHIPPING_METHOD_ID
                  }
                  actions={{ change: handleShippingMethodSelection }}
                />
              ) : (
                <>
                  <RadioInput
                    value={methodId}
                    label={methodName}
                    name="shippingMethod"
                    checked={selectedMethodId === methodId}
                    disabled={
                      hasRequiredCategoryMethod &&
                      methodId !== CATEGORY_SHIPPING_METHOD_ID
                    }
                    onChange={handleShippingMethodSelection}
                  />
                  <span className="pt-2 pl-3 font-semibold">
                    {__('Price: %1', price)}
                  </span>
                </>
              )}
            </li>
          );
        })}
      </ul>
    </div>
  );
}

ShippingMethodList.propTypes = {
  methodRenderers: object,
};

ShippingMethodList.defaultProps = {
  methodRenderers: {},
};

export default ShippingMethodList;
