import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ProductItem from './ProductItem';
import { useNavigate } from 'react-router-dom';

const ProductList = () => {
  const [products, setProducts] = useState([]);
  const [newProductAdded, setNewProductAdded] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    fetchProducts();
  }, [newProductAdded]);

  const fetchProducts = async () => {
    try {
      const readResponse = await axios.get('http://localhost:8000/backend/read.php');

      if (readResponse.status === 200) {
        const data = readResponse.data;
        setProducts(data);
      } else {
        console.log('Error fetching products');
      }
    } catch (error) {
      console.log('Error fetching products:', error);
    }
  };

  const handleDelete = async (sku) => {
    try {
      await axios.delete(`http://localhost:8000/backend/delete.php?sku=${sku}`);
      setProducts(prevProducts => prevProducts.filter(product => product.sku !== sku));
    } catch (error) {
      console.log('Error deleting product:', error);
    }
  };

  const handleMassDelete = async () => {
    const selectedProducts = products.filter((product) => product.selected);
    const selectedSkus = selectedProducts.map((product) => product.sku);

    try {
      await axios.delete('http://localhost:8000/backend/delete.php', { data: { skus: selectedSkus } });
      const updatedProducts = products.filter((product) => !selectedSkus.includes(product.sku));
      setProducts(updatedProducts);
    } catch (error) {
      console.log('Error deleting selected products:', error);
    }
  };

  const handleNewProductAdded = () => {
    navigate('/add-product');
  };

  const handleCheckboxChange = (sku) => {
    setProducts(prevProducts =>
      prevProducts.map(product =>
        product.sku === sku ? { ...product, selected: !product.selected } : product
      )
    );
  };

  return (
    <div>
      <h1>Product List</h1>
      {Array.isArray(products) && products.length > 0 ? (
        products.map((product) => (
          <ProductItem key={product.sku} product={product} onDelete={handleDelete} onCheckboxChange={handleCheckboxChange} />
        ))
      ) : (
        <p>No products available.</p>
      )}
      {Array.isArray(products) && products.length > 0 && (
        <>
          <button id='delete-product-btn' type="button" onClick={handleMassDelete}>
            MASS DELETE
          </button>
          <button type="button" onClick={handleNewProductAdded}>ADD</button>
        </>
      )}
    </div>
  );
};

export default ProductList;

