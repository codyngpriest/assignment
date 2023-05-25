import React from 'react';

function ProductItem({ product, onCheckboxChange }) {

  const handleCheckboxChange = () => {
    onCheckboxChange(product.sku);
  };

  return (
    <div>
      <input
        className='delete-checkbox'
        type="checkbox"
        checked={product.selected || false}
        onChange={handleCheckboxChange}
      />
      <h3>{product.sku}</h3>
      <p>{product.name}</p>
      <p>{product.price} $</p>

      {product.type === 'Book' && (
        <div>
          <p>Weight: {product.weight}KG</p>
        </div>
      )}

      {product.type === 'DVD' && (
        <div>
          <p>Size: {product.size} MB</p>
        </div>
      )}

      {product.type === 'Furniture' && (
        <div>
          <p>Dimensions: {product.length} x {product.width} x {product.height}</p>
        </div>
      )}
    </div>
  );
}

export default ProductItem;

