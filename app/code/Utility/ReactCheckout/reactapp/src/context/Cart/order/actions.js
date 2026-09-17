import { get as _get } from 'lodash-es';

import { SET_ORDER_INFO } from './types';
import { placeOrderRequest } from '../../../api';
import { PAYMENT_METHOD_FORM } from '../../../config';
import { SET_PAGE_MESSAGE } from '../../App/page/types';

export function setOrderInfoAction(dispatch, appDispatch, order) {
  dispatch({
    type: SET_ORDER_INFO,
    payload: order,
  });
}

export async function placeOrderAction(
  dispatch,
  appDispatch,
  values,
  paymentActionList
) {
  try {
    let order;
    const paymentMethod = _get(values, PAYMENT_METHOD_FORM);
    const paymentSubmitAction = _get(paymentActionList, paymentMethod.code);

    if (paymentSubmitAction) {
      order = await paymentSubmitAction(values);
    } else {
      order = await placeOrderRequest(appDispatch);
    }

    if (order) {
      dispatch({
        type: SET_ORDER_INFO,
        payload: order,
      });
    }

    return order;
  } catch (error) {
    console.error(error);
    const paymentMethodCode = _get(values, `${PAYMENT_METHOD_FORM}.code`, '');
    const isPayPalMethod = paymentMethodCode.toLowerCase().includes('paypal');

    appDispatch({
      type: SET_PAGE_MESSAGE,
      payload: {
        type: 'error',
        message: isPayPalMethod
          ? 'PayPal could not authorize the payment. Please try again or choose another payment method.'
          : error.message || 'The order could not be placed. Please try again.',
      },
    });
  }

  return {};
}
