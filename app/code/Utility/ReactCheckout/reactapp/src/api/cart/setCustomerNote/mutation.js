export const SET_CUSTOMER_NOTE_MUTATION = `
mutation setCustomerNoteOnCart($cartId: String!, $note: String!) {
  setCustomerNoteOnCart(input: { cart_id: $cartId, note: $note }) {
    cart {
      customer_note
    }
  }
}`;
