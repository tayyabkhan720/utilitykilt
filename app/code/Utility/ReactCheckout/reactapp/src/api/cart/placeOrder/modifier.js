import { get as _get } from 'lodash-es';

export default function modifyPlaceOrder(result) {
  const order = _get(result, 'data.placeOrder.order');

  if (!order) {
    throw new Error('The order could not be placed. Please try again.');
  }

  return order;
}
