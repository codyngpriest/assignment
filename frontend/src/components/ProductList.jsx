import React, { useEffect, useState } from 'react';
import axios from 'axios';
import ProductItem from './ProductItem';
import { useNavigate } from 'react-router-dom';
import Header from './Header.jsx';
import Footer from './Footer.jsx';

const ProductList = () => {
  const [products, setProducts] = useState([]);
  const [newProductAdded, setNewProductAdded] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    fetchProducts();
  }, [newProductAdded]);

  const fetchProducts = async () => {
    try {
      const readResponse = await axios.get('http://132.148.79.85/backend/read.php');

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
      await axios.delete(`http://132.148.79.85/backend/delete.php?sku=${sku}`);
      setProducts(prevProducts => prevProducts.filter(product => product.sku !== sku));
    } catch (error) {
      console.log('Error deleting product:', error);
    }
  };

  const handleMassDelete = async () => {
    const selectedProducts = products.filter((product) => product.selected);
    const selectedSkus = selectedProducts.map((product) => product.sku);

    try {
      await axios.delete('http://132.148.79.85/backend/delete.php', { data: { skus: selectedSkus } });
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
    <>
      <Header />
    <div className="p-4">
      <div className="flex justify-between items-center mb-4">
        <h1 className="text-orange-600 font-bold text-4xl">Product List</h1>
        {Array.isArray(products) && products.length > 0 && (
          <div className="flex space-x-2">
            <button
              className="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-4 rounded"
              id="delete-product-btn"
              type="button"
              onClick={handleNewProductAdded}
            >
              ADD
            </button>
            <button
              className="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
              type="button"
              onClick={handleMassDelete}
            >
              MASS DELETE
            </button>
          </div>
        )}
      </div>
      <div className='border-b-4 border-black mb-5 mt-10'></div>

      {Array.isArray(products) && products.length > 0 ? (
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-10 pt-4">
          {products.map((product) => (
            <div key={product.sku} className="border p-4 shadow-md rounded-lg">
              <ProductItem
                key={product.sku}
                product={product}
                onDelete={handleDelete}
                onCheckboxChange={handleCheckboxChange}
              />
            </div>
          ))}
        </div>
      ) : (
        <p className='text-red-600 mt-4'>No products available!</p>
      )}
    <div className='border-b-4 border-black mb-5 mt-10'></div>
    </div>
      <Footer />
    </>
  );
};

export default ProductList;


