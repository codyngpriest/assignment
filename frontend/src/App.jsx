import React from 'react';
import { Routes, Route } from 'react-router-dom';
import ProductList from './components/ProductList';
import AddProduct from './components/AddProduct';
import 'tailwindcss/tailwind.css';

function App() {
  return (
    <div>
      <Routes>
        <Route exact path="/" element={<ProductList />} />
	<Route path="/add-product" element={<AddProduct />} />
      </Routes>
    </div>
  );
}

export default App;

