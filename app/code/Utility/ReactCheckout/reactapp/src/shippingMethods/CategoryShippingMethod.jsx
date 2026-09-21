import React from 'react';
import { func, shape, string } from 'prop-types';

import RadioInput from '../components/common/Form/RadioInput';
import { __ } from '../i18n';

function CategoryShippingMethod({ method, selected, actions }) {
  const selectedMethodId = selected
    ? `${selected.carrierCode}__${selected.methodCode}`
    : '';

  return (
    <div className="w-full">
      <RadioInput
        value={method.id}
        label={`${method.carrierTitle} (${method.methodTitle}): `}
        name="shippingMethod"
        checked={selectedMethodId === method.id}
        onChange={actions.change}
      />
      <div className="pl-8 text-sm">
        {__('Shipping is calculated from the categories in your cart.')}
      </div>
      <div className="pt-1 pl-8 font-semibold">{method.price}</div>
    </div>
  );
}

CategoryShippingMethod.propTypes = {
  method: shape({
    id: string.isRequired,
    carrierTitle: string.isRequired,
    methodTitle: string.isRequired,
    price: string.isRequired,
  }).isRequired,
  selected: shape({
    carrierCode: string,
    methodCode: string,
  }),
  actions: shape({
    change: func.isRequired,
  }).isRequired,
};

CategoryShippingMethod.defaultProps = {
  selected: null,
};

export default CategoryShippingMethod;
