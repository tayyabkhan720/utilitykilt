import {
  applyCouponCodeAction,
  removeCouponCodeAction,
} from './couponCode/actions';
import {
  setBillingAddressAction,
  setCustomerAddrAsBillingAddrAction,
} from './billingAddress/actions';
import {
  setPaymentMethodAction,
  setRestPaymentMethodAction,
} from './paymentMethod/actions';
import {
  mergeCartsAction,
  setCartInfoAction,
  createEmptyCartAction,
  getGuestCartInfoAction,
  getCustomerCartIdAction,
  getCartInfoAfterMergeAction,
} from './cart/actions';
import {
  setShippingMethodAction,
  estimateShippingMethodsAction,
} from './shippingMethod/actions';
import {
  addCartShippingAddressAction,
  setSelectedShippingAddressAction,
  setCustomerAddrAsShippingAddrAction,
} from './shippingAddress/actions';
import { updateCartItemAction } from './cartItems/actions';
import { setEmailOnGuestCartAction } from './email/actions';
import { placeOrderAction, setOrderInfoAction } from './order/actions';
import { storeAggregatedCartStatesAction } from './aggregated/actions';
import { setCustomerNoteAction } from './customerNote/actions';

const dispatchMapper = {
  placeOrder: placeOrderAction,
  mergeCarts: mergeCartsAction,
  setCartInfo: setCartInfoAction,
  setOrderInfo: setOrderInfoAction,
  updateCartItem: updateCartItemAction,
  createEmptyCart: createEmptyCartAction,
  applyCouponCode: applyCouponCodeAction,
  getGuestCartInfo: getGuestCartInfoAction,
  setPaymentMethod: setPaymentMethodAction,
  removeCouponCode: removeCouponCodeAction,
  setShippingMethod: setShippingMethodAction,
  estimateShippingMethods: estimateShippingMethodsAction,
  getCustomerCartId: getCustomerCartIdAction,
  getCustomerCartInfo: getGuestCartInfoAction,
  setEmailOnGuestCart: setEmailOnGuestCartAction,
  setCartBillingAddress: setBillingAddressAction,
  setRestPaymentMethod: setRestPaymentMethodAction,
  getCartInfoAfterMerge: getCartInfoAfterMergeAction,
  addCartShippingAddress: addCartShippingAddressAction,
  storeAggregatedCartStates: storeAggregatedCartStatesAction,
  setCartSelectedShippingAddress: setSelectedShippingAddressAction,
  setCustomerAddressAsBillingAddress: setCustomerAddrAsBillingAddrAction,
  setCustomerAddressAsShippingAddress: setCustomerAddrAsShippingAddrAction,
  setCustomerNote: setCustomerNoteAction,
};

function cartDispatchers(dispatch, appDispatch) {
  const dispatchers = { dispatch };

  Object.keys(dispatchMapper).forEach((dispatchName) => {
    dispatchers[dispatchName] = dispatchMapper[dispatchName].bind(
      null,
      dispatch,
      appDispatch
    );
  });

  return dispatchers;
}

export default cartDispatchers;
