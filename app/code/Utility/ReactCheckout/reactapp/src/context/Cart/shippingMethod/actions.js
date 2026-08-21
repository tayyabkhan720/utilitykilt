import { SET_CART_INFO } from '../cart/types';
import {
  setShippingMethodRequest,
  estimateShippingMethodsRequest,
} from '../../../api';

export async function setShippingMethodAction(
  dispatch,
  appDispatch,
  shippingMethod
) {
  try {
    const cartData = await setShippingMethodRequest(
      appDispatch,
      shippingMethod
    );

    dispatch({
      type: SET_CART_INFO,
      payload: cartData,
    });
  } catch (error) {
    /** @todo error message */
  }
}

// NEW ACTION — only touches shipping_methods / selected_shipping_method,
// never shipping_address or billing_address, so the "saved address" UI
// never mistakes the placeholder for a real address.
export async function estimateShippingMethodsAction(
  dispatch,
  appDispatch,
  countryCode
) {
  try {
    const cartData = await estimateShippingMethodsRequest(
      appDispatch,
      countryCode
    );

    dispatch({
      type: SET_CART_INFO,
      payload: {
        shipping_methods: cartData.shipping_methods,
        selected_shipping_method: cartData.selected_shipping_method,
      },
    });
  } catch (error) {
    /** @todo error message */
  }
}
