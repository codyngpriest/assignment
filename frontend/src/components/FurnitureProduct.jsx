import React from 'react';

const FurnitureProduct = ({ sku, name, price, dimensions }) => {
  const { height, width, length } = dimensions;
  return (
    <div>
      <h3>{sku}</h3>
      <p>{name}</p>
      <p>{price} $</p>
      <p>Dimensions: {height} x {width} x {length}</p>
    </div>
  );
};

export default FurnitureProduct;

