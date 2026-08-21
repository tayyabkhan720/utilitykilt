import React, { useRef, useCallback, useEffect } from 'react';

import TextInput from '../../common/Form/TextInput';
import SelectInput from '../../common/Form/SelectInput';
import CancelButton from './shippingAddressForm/CancelButton';
import BillingSameAsShippingCheckbox from './BillingSameAsShippingCheckbox';
import SaveInBookCheckbox from '../../address/components/SaveInBookCheckbox';
import { __ } from '../../../i18n';
import { _keys } from '../../../utils';
import LocalStorage from '../../../utils/localStorage';
import {
  isValidCustomerAddressId,
  isCartAddressValid,
} from '../../../utils/address';
import useCountryState from '../../address/hooks/useCountryState';
import useAddressWrapper from '../../address/hooks/useAddressWrapper';
import useFormValidateThenSubmit from '../../../hook/useFormValidateThenSubmit';
import useShippingAddressAppContext from '../hooks/useShippingAddressAppContext';
import useShippingAddressFormikContext from '../hooks/useShippingAddressFormikContext';
import useShippingAddressCartContext from '../hooks/useShippingAddressCartContext';
import { isAddressSame } from '../../placeOrder/utility';

function ShippingAddressForm() {
  const {
    fields,
    formId,
    viewMode,
    formikData,
    handleKeyDown,
    submitHandler,
    isBillingSame,
    setFieldValue,
    shippingValues,
    selectedCountry,
    selectedAddress,
    setIsNewAddress,
    setFieldTouched,
    validationSchema,
    setSelectedAddress,
  } = useShippingAddressFormikContext();
  const { isLoggedIn } = useShippingAddressAppContext();
  const { reCalculateMostRecentAddressOptions } = useAddressWrapper();
  const { countryOptions, stateOptions, hasStateOptions } = useCountryState({
    fields,
    formikData,
  });
  const { cartShippingAddress, estimateShippingMethods } =
    useShippingAddressCartContext();
  const formSubmitHandler = useFormValidateThenSubmit({
    formId,
    formikData,
    submitHandler,
    validationSchema,
  });

  // Save action (moved before effect and wrapped with useCallback to satisfy eslint)
  const saveAddressAction = useCallback(async () => {
    let newAddressId = selectedAddress;

    // Updating mostRecentAddressList in prior to form submit; Because values
    // there would be used in the submit action if the address is from
    // mostRecentAddressList.
    if (isLoggedIn) {
      if (isValidCustomerAddressId(selectedAddress)) {
        // This means a customer address been edited and now changed and submitted.
        // So treat this as a new address;
        const recentAddressList = LocalStorage.getMostRecentlyUsedAddressList();
        newAddressId = `new_address_${_keys(recentAddressList).length + 1}`;
        LocalStorage.addAddressToMostRecentlyUsedList(
          shippingValues,
          newAddressId
        );
      } else {
        LocalStorage.updateMostRecentlyAddedAddress(
          newAddressId,
          shippingValues
        );
      }
    }

    await formSubmitHandler(newAddressId);

    if (!isLoggedIn) {
      return;
    }

    setIsNewAddress(false);
    setSelectedAddress(newAddressId);
    LocalStorage.saveCustomerAddressInfo(newAddressId, isBillingSame);
    reCalculateMostRecentAddressOptions();
  }, [
    selectedAddress,
    isLoggedIn,
    shippingValues,
    formSubmitHandler,
    setIsNewAddress,
    setSelectedAddress,
    isBillingSame,
    reCalculateMostRecentAddressOptions,
  ]);

  // Save on field blur (like default checkout) and avoid repeated saves of identical data
  const lastSavedValuesRef = useRef(null);

  const handleFieldBlur = useCallback(
    async (/* event */) => {
      try {
        if (!isCartAddressValid(shippingValues)) {
          return;
        }

        // If the cart already contains the same address (server-normalized), avoid re-saving
        if (
          cartShippingAddress &&
          isAddressSame(cartShippingAddress, shippingValues)
        ) {
          // keep lastSavedValuesRef in sync so subsequent blurs don't re-trigger
          lastSavedValuesRef.current = JSON.stringify(shippingValues || {});
          return;
        }

        const current = JSON.stringify(shippingValues || {});
        if (lastSavedValuesRef.current === current) {
          return;
        }

        await saveAddressAction();
        lastSavedValuesRef.current = current;
      } catch (err) {
        // swallow - saveAddressAction handles errors and messages
      }
    },
    [shippingValues, saveAddressAction, cartShippingAddress]
  );

  const handleCountryChange = (event) => {
    const newValue = event.target.value;
    setFieldTouched(fields.country, newValue);
    setFieldValue(fields.country, newValue);
    // when country is changed, then always reset region field.
    setFieldValue(fields.region, '');

    // Fire estimate call as soon as country is picked so shipping methods
    // appear before the rest of the address is filled — mirrors default
    // Magento Luma checkout behaviour.
    if (newValue) {
      estimateShippingMethods(newValue);
    }
  };
  const hasEstimatedOnMount = useRef(false);
  useEffect(() => {
    if (selectedCountry && !hasEstimatedOnMount.current) {
      hasEstimatedOnMount.current = true;
      estimateShippingMethods(selectedCountry);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [selectedCountry]);

  if (viewMode) {
    return null;
  }

  return (
    <>
      <div className="py-2">
        <div className="flex">
          <TextInput
            required
            name={fields.firstname}
            formikData={formikData}
            label={__('First name')}
            onKeyDown={handleKeyDown}
            onBlur={handleFieldBlur}
            placeholder={__('First name')}
          />
          <TextInput
            required
            name={fields.lastname}
            label={__('Last name')}
            formikData={formikData}
            onKeyDown={handleKeyDown}
            onBlur={handleFieldBlur}
            placeholder={__('Last name')}
          />
        </div>
        <div className="flex space-between">
          <TextInput
            required
            label={__('Phone')}
            name={fields.phone}
            formikData={formikData}
            onKeyDown={handleKeyDown}
            onBlur={handleFieldBlur}
            placeholder={__('+32 000 000 000')}
          />

          <TextInput
            required
            label={__('Company')}
            name={fields.company}
            formikData={formikData}
            onKeyDown={handleKeyDown}
            onBlur={handleFieldBlur}
            placeholder={__('Company')}
          />
        </div>
        <TextInput
          required
          label={__('Street')}
          formikData={formikData}
          onKeyDown={handleKeyDown}
          onBlur={handleFieldBlur}
          placeholder={__('Street')}
          name={`${fields.street}[0]`}
        />
        <div className="flex">
          <SelectInput
            required
            label={__('Country')}
            name={fields.country}
            formikData={formikData}
            options={countryOptions}
            onChange={handleCountryChange}
            onBlur={handleFieldBlur}
          />

          <SelectInput
            required
            label={__('State')}
            name={fields.region}
            options={stateOptions}
            formikData={formikData}
            isHidden={!selectedCountry || !hasStateOptions}
            onBlur={handleFieldBlur}
          />
        </div>
        <div className="flex">
          <TextInput
            required
            placeholder="12345"
            name={fields.zipcode}
            formikData={formikData}
            label={__('Postal Code')}
            onKeyDown={handleKeyDown}
            onBlur={handleFieldBlur}
          />
          <TextInput
            required
            label={__('City')}
            name={fields.city}
            formikData={formikData}
            placeholder={__('City')}
            onKeyDown={handleKeyDown}
            onBlur={handleFieldBlur}
          />
        </div>

        <SaveInBookCheckbox fields={fields} formikData={formikData} />
        <div className="mt-4">
          <BillingSameAsShippingCheckbox />
        </div>
      </div>

      <div className="flex items-center justify-start mt-2">
        <CancelButton />
      </div>
    </>
  );
}

export default ShippingAddressForm;
