import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ProductItem from './ProductItem';

const ProductList = () => {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchProducts = async () => {
    try {
      const readResponse = await axios.get('http://localhost:8000/backend/index.php', {
        headers: {
          'Access-Control-Allow-Origin': 'http://localhost:5173', // Replace with your frontend domain
          'Access-Control-Allow-Methods': 'GET, OPTIONS', // Adjust based on allowed methods in your backend
        },
      });

      if (readResponse.status === 200) {
        const data = readResponse.data;
        console.log(data);
        setProducts(data.products); // Update the product list in your state or context
      } else {
        console.log('Error fetching products');
      }
    } catch (error) {
      console.log('Error fetching products:', error);
    }
  };

  const handleDelete = async (sku) => {
    try {
      await axios.delete(`http://localhost:8000/backend/class/Product.php?sku=${sku}`, {
        headers: {
          'Access-Control-Allow-Origin': 'http://localhost:5173', // Replace with your frontend domain
          'Access-Control-Allow-Methods': 'DELETE, OPTIONS', // Adjust based on allowed methods in your backend
        },
      });
      setProducts(prevProducts => prevProducts.filter(product => product.sku !== sku)); // Update the product list
    } catch (error) {
      console.log('Error deleting product:', error);
    }
  };

  const handleMassDelete = async () => {
    const selectedProducts = products.filter((product) => product.selected);
    const selectedSkus = selectedProducts.map((product) => product.sku);

    try {
      await axios.delete(`http://localhost:8000/backend/class/Product.php?skus=${selectedSkus.join(',')}`, {
        headers: {
          'Access-Control-Allow-Origin': 'http://localhost:5173', // Replace with your frontend domain
          'Access-Control-Allow-Methods': 'DELETE, OPTIONS', // Adjust based on allowed methods in your backend
        },
      });
      const updatedProducts = products.filter((product) => !selectedSkus.includes(product.sku));
      setProducts(updatedProducts);
    } catch (error) {
      console.log('Error deleting selected products:', error);
    }
  };

  return (
    <div>
      <h1>Product List</h1>
      {Array.isArray(products) && products.length > 0 ? (
        products.map((product) => (
          <ProductItem key={product.sku} product={product} onDelete={handleDelete} />
        ))
      ) : (
        <p>No products available.</p>
      )}
      {Array.isArray(products) && products.length > 0 && (
        <>
          <button type="button" onClick={handleMassDelete}>
            Mass Delete
          </button>
          <button type="button" onClick={handleAddProduct}>
            Add Product
          </button>
        </>
      )}
    </div>
  );
};

export default ProductList;

