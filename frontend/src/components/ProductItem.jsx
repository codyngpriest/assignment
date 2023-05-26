import React from 'react';

function ProductItem({ product, onCheckboxChange }) {
  const handleCheckboxChange = () => {
    onCheckboxChange(product.sku);
  };

  return (
    <div>
      <input
        className="delete-checkbox"
        type="checkbox"
        checked={product.selected || false}
        onChange={handleCheckboxChange}
      />
      <div className='text-center italic'>
      <h3 className="text-sm font-black font-thin">{product.sku}</h3>
      <p className="text-sm">{product.name}</p>
      <p className="text-sm">{product.price} $</p>

      {product.type === 'Book' && (
        <div>
          <p className="text-sm">Weight: {product.weight}KG</p>
        </div>
      )}

      {product.type === 'DVD' && (
        <div>
          <p className="text-sm">Size: {product.size} MB</p>
        </div>
      )}

      {product.type === 'Furniture' && (
        <div>
          <p className="text-sm">Dimensions: {product.length} x {product.width} x {product.height}</p>
        </div>
      )}
    </div>
    </div>
  );
}

export default ProductItem;

