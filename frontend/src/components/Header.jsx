import React from 'react';
import { Link } from 'react-router-dom';
import logo from '../assets/scandiLogo.png';

function Header() {
  return (
    <header className="flex justify-between items-center p-4 bg-gray-200">
      <div className="flex items-center mb-4 sm:mb-0">
        <img src={logo} alt="Scandiweb Logo" className="w-12 h-12 mr-4" />
        <h1 className="text-2xl text-orange-600">Scandiweb</h1>
      </div>
      <div className="flex flex-col sm:flex-row">
        <Link to="/add-product" className="mr-4 mb-2 sm:mb-0 bg-gray-200 px-4 py-2 rounded-md text-md text-bold text-orange-600">Add Product</Link>
        <Link to="/" className="mr-4 mb-2 sm:mb-0 bg-gray-200 px-4 py-2 rounded-md text-md text-bold text-orange-600">Product List</Link>
      </div>
    </header>
  );
}

export default Header;




































