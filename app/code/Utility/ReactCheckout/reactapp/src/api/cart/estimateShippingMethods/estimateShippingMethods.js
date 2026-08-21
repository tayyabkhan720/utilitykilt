import setShippingAddress from '../setShippingAddress/setShippingAddress';
import { ESTIMATE_PLACEHOLDER_FIRSTNAME } from '../../../utils/estimateAddressConstants';

const ESTIMATE_PLACEHOLDER_VALUES = {
  firstname: ESTIMATE_PLACEHOLDER_FIRSTNAME,
  lastname: 'Estimate',
  company: '',
  street: ['Estimate'],
  city: 'Estimate',
  zipcode: '00000',
  phone: '00000000000',
  saveInBook: false,
};

const DEFAULT_REGION_ID_BY_COUNTRY = {
  US: 12,
  CA: 1,
  AU: 1,
};

export default async function estimateShippingMethods(dispatch, countryCode) {
  const regionId = DEFAULT_REGION_ID_BY_COUNTRY[countryCode] || null;

  return setShippingAddress(dispatch, {
    ...ESTIMATE_PLACEHOLDER_VALUES,
    country: countryCode,
    region: '',
    regionId,
  });
}
