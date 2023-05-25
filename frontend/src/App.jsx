import React from 'react';
import { Routes, Route } from 'react-router-dom';
import AddProduct from './components/AddProduct';
import ProductList from './components/ProductList';
import HomePage from './components/HomePage';
import 'tailwindcss/tailwind.css';

function App() {
  return (
    <div>
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/add-product" element={<AddProduct />} />
        <Route path="/product-list" element={<ProductList />} />
      </Routes>
    </div>
  );
}

export default App;

