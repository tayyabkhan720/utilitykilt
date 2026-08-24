import { SET_CART_INFO } from '../cart/types';
import { setCustomerNoteRequest } from '../../../api';

export async function setCustomerNoteAction(dispatch, appDispatch, note) {
  try {
    const customerNote = await setCustomerNoteRequest(appDispatch, note);

    dispatch({
      type: SET_CART_INFO,
      payload: { customer_note: customerNote },
    });
  } catch (error) {
    /** @todo error message */
  }
}
