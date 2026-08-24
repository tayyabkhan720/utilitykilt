import React, { useState, useRef, useCallback, useContext } from 'react';

import { __ } from '../../i18n';
import CartContext from '../../context/Cart/CartContext';

function CustomerNote() {
  const [cartData, cartActions] = useContext(CartContext);
  const { setCustomerNote } = cartActions;
  const existingNote = cartData?.cart?.customer_note || '';

  const [note, setNote] = useState(existingNote);
  const lastSavedRef = useRef(existingNote);

  const handleBlur = useCallback(() => {
    const trimmed = note.trim();
    if (trimmed === lastSavedRef.current) {
      return;
    }
    lastSavedRef.current = trimmed;
    setCustomerNote(trimmed);
  }, [note, setCustomerNote]);

  return (
    <div className="py-4">
      <label
        htmlFor="order-comment"
        className="block mb-2 md:text-sm font-medium"
      >
        {__('Order Comments')}
      </label>
      <textarea
        id="order-comment"
        name="order-comment"
        rows="3"
        className="w-full p-2 border-[#ececec] rounded-lg xs:block max-w-md"
        placeholder={__(
          'Add any special instructions for your order (optional)'
        )}
        value={note}
        onChange={(e) => setNote(e.target.value)}
        onBlur={handleBlur}
      />
    </div>
  );
}

export default CustomerNote;
