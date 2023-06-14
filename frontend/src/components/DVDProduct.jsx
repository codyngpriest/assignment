import React from 'react';

const DVDProduct = ({ sku, name, price, size }) => {
  return (
    <div>
      <h3>{sku}</h3>
      <p>{name}</p>
      <p>{price} $</p>
      <p>Size: {size} MB</p>
    </div>
  );
};

export default DVDProduct;

