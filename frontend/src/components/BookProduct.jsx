import React from 'react';

const BookProduct = ({ sku, name, price, weight }) => {
  return (
    <div>
      <h3>{sku}</h3>
      <p>{name}</p>
      <p>{price} $</p>
      <p>Weight: {weight} Kg</p>
    </div>
  );
};

export default BookProduct;

