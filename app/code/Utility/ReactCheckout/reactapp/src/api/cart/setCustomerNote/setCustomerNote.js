import sendRequest from '../../sendRequest';
import LocalStorage from '../../../utils/localStorage';
import { SET_CUSTOMER_NOTE_MUTATION } from './mutation';

export default async function setCustomerNote(dispatch, note) {
  const variables = { cartId: LocalStorage.getCartId(), note };

  const response = await sendRequest(dispatch, {
    query: SET_CUSTOMER_NOTE_MUTATION,
    variables,
  });

  return response?.data?.setCustomerNoteOnCart?.cart?.customer_note ?? '';
}
