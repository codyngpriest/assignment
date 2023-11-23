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
      const readResponse = await axios.get('http://34.70.175.99:9000/app/product/read');

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

  
  const handleDelete = async (id) => {
  try {
    await axios.delete(`http://34.70.175.99:9000/app/product/delete-selected/${id}`);
    setProducts(prevProducts => prevProducts.filter(product => product.id !== id));
  } catch (error) {
    console.error('Error deleting product with ID ${id}:', error);
  }
};

const handleMassDelete = async () => {
  const selectedProducts = products.filter((product) => product.selected);
  const selectedIds = selectedProducts.map((product) => product.id);
  console.log('Selected IDs:', selectedIds);
  try {
    await axios({
      method: 'delete',
      url: 'http://34.70.175.99:9000/app/product/delete-selected',
      data: { ids: selectedIds },
      headers: { 'Content-Type': 'application/json' },
    });

    const updatedProducts = products.filter((product) => !selectedIds.includes(product.id));
    setProducts(updatedProducts);
  } catch (error) {
    console.eror('Error deleting selected products:', error);
  }
};
 
  const handleNewProductAdded = () => {
    navigate('/add-product');
  };

  const handleCheckboxChange = (id) => {
    setProducts(prevProducts =>
      prevProducts.map(product =>
        product.id === id ? { ...product, selected: !product.selected } : product
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
              type="button"
              onClick={handleNewProductAdded}
            >
              ADD
            </button>
            <button
              className="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
              type="button"
	      id="delete-product-btn"
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
            <div key={product.id} className="border p-4 shadow-md rounded-lg">
              <ProductItem
                key={product.id}
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


