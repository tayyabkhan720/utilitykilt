import React from 'react';

import Login from '../login';
import Totals from '../totals';
import CartItemsForm from '../items';
import PlaceOrder from '../placeOrder';
import CouponCode from '../couponCode';
import Message from '../common/Message';
import PageLoader from '../common/Loader';
import { AddressWrapper } from '../address';
import PaymentMethod from '../paymentMethod';
import BillingAddress from '../billingAddress';
import ShippingAddress from '../shippingAddress';
import ShippingMethodsForm from '../shippingMethod';
import StickyRightSidebar from '../StickyRightSidebar';
import CheckoutAgreements from '../checkoutAgreements';
import { config } from '../../config';
import useCheckoutFormAppContext from './hooks/useCheckoutFormAppContext';
import useCheckoutFormCartContext from './hooks/useCheckoutFormCartContext';

function CheckoutForm() {
  const { orderId, isVirtualCart } = useCheckoutFormCartContext();
  const { pageLoader } = useCheckoutFormAppContext();

  // Read the layout configuration injected from Magento (defaults to 'three-column')
  const layoutVariant =
    window.hyvaCheckoutConfig?.layoutVariant || 'three-column';
  const isTwoColumn = layoutVariant === 'two-column';

  if (orderId && config.isDevelopmentMode) {
    return (
      <div className="flex flex-col items-center justify-center mx-10 my-10">
        <h1 className="text-2xl font-bold">Order Details</h1>
        <div className="flex flex-col items-center justify-center mt-4 space-y-3">
          <div>Your order is placed.</div>
          <div>{`Order Number: #${orderId}`}</div>
        </div>
      </div>
    );
  }

  return (
    <>
      <Message />
      <div className="flex justify-center">
        <div className="container">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 my-6 appcode">
            <div
              className={`w-full space-y-2 ${
                isTwoColumn ? 'lg:col-span-2' : ''
              }`}
            >
              <Login />
              <AddressWrapper>
                {!isVirtualCart && <ShippingAddress />}
                <BillingAddress />
                {isTwoColumn && !isVirtualCart && <ShippingMethodsForm />}
              </AddressWrapper>

              {isTwoColumn && (
                <>
                  <PaymentMethod />
                  <CouponCode />
                </>
              )}
            </div>

            {!isTwoColumn && (
              <div className="w-full space-y-2">
                <AddressWrapper>
                  {!isVirtualCart && <ShippingMethodsForm />}
                </AddressWrapper>
                <PaymentMethod />
                <CouponCode />
              </div>
            )}

            <StickyRightSidebar>
              <CartItemsForm />
              <Totals />
              <CheckoutAgreements />
              <PlaceOrder />
            </StickyRightSidebar>
          </div>
          {pageLoader && <PageLoader />}
        </div>
      </div>
    </>
  );
}

export default CheckoutForm;
