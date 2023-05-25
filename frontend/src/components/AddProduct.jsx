import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

function AddProduct() {
  const [sku, setSku] = useState('');
  const [name, setName] = useState('');
  const [price, setPrice] = useState('');
  const [productType, setProductType] = useState('Type Switcher');
  const [size, setSize] = useState('');
  const [weight, setWeight] = useState('');
  const [height, setHeight] = useState('');
  const [width, setWidth] = useState('');
  const [length, setLength] = useState('');
  const [notification, setNotification] = useState('');
  const [products, setProducts] = useState([]);

  const navigate = useNavigate();

  const fetchProducts = async () => {
    try {
      const response = await axios.get('http://localhost:8000/backend/read.php');
      setProducts(response.data);
    } catch (error) {
      console.error('Error fetching products', error);
    }
  };

  useEffect(() => {
    fetchProducts();
  }, []);

  const handleFormSubmit = async (e) => {
    e.preventDefault();

    // Validate form data
    if (!sku || !name || !price) {
      alert('Please provide all required fields.');
      return;
    }

    // Check for duplicate SKU
    const duplicateProduct = products.find((product) => product.sku === sku);
    if (duplicateProduct) {
      setNotification('A product with the same SKU already exists.');
      return;
    }

    // Create a new product object based on the form data
    const newProduct = {
      sku,
      name,
      price,
      type: productType,
      length,
      width,
      height,
      size,
      weight,
    };

    console.log(newProduct) // help debug

    // Add additional properties based on the selected product type
    if (productType === 'Book') {
      if (!weight) {
        alert('Please provide the weight.');
        return;
      }
      newProduct.weight = weight;
    } else if (productType === 'DVD') {
      if (!size) {
        alert('Please provide the size.');
        return;
      }
      newProduct.size = size;
    } else if (productType === 'Furniture') {
      if (!length || !width || !height) {
        alert('Please provide the dimensions.');
        return;
      }
      newProduct.length = length;
      newProduct.width = width;
      newProduct.height = height;
    }

    try {
      // Add the new product
      const addResponse = await axios.post('http://localhost:8000/backend/add.php', newProduct);

      if (addResponse.status === 200) {
        setNotification('Product added successfully');
        // Reset form fields
        setSku('');
        setName('');
        setPrice('');
        setProductType('Type Switcher');
        setSize('');
        setWeight('');
        setHeight('');
        setWidth('');
        setLength('');

        // Fetch updated product list
        fetchProducts();

        // Redirect to the product list page
        navigate('/product-list');
      } else {
        console.error('Error adding product');
      }
    } catch (error) {
      console.error('Error adding product', error);
    }
  };
  const handleCancel = () => {
    // Reset form fields
    setSku('');
    setName('');
    setPrice('');
    setProductType('Type Switcher');
    setSize('');
    setWeight('');
    setHeight('');
    setWidth('');
    setLength('');

    // Redirect to the product list page
    navigate('/product-list');
  };

return (
  <div>
    <h3>Product Add</h3>
    <form onSubmit={handleFormSubmit} id='product_form'>
      {notification && <p>{notification}</p>}
      <div>
        <label htmlFor="sku">SKU</label>
        <input
          type="text"
          id="sku"
          value={sku}
          onChange={(e) => setSku(e.target.value)}
          placeholder="Please, enter SKU"
          required
        />
      </div>
      <div>
        <label htmlFor="name">Name</label>
        <input
          type="text"
          id="name"
          value={name}
          onChange={(e) => setName(e.target.value)}
          placeholder="Please, enter name"
          required
        />
      </div>
      <div>
        <label htmlFor="price">Price($)</label>
        <input
          type="number"
          id="price"
          value={price}
          onChange={(e) => setPrice(e.target.value)}
          placeholder="Please enter price"
          required
        />
      </div>
      <div>
        <label htmlFor="productType">Type Switcher</label>
        <select
          id="productType"
          value={productType}
          onChange={(e) => setProductType(e.target.value)}
          required
        >
          <option value="TypeSwitcher">Type Switcher</option>
          <option id='Furniture' value="Furniture">Furniture</option>
          <option  id='DVD' value="DVD">DVD-disc</option>
          <option  id='Book' value="Book">Book</option>
        </select>
      </div>
      {productType === 'Furniture' && (
        <>
          <div>
            <label htmlFor="height">Height (CM):</label>
            <input
              type="number"
              id="height"
              value={height}
              onChange={(e) => setHeight(e.target.value)}
              placeholder="Please, enter height"
              required
            />
          </div>
          <div>
            <label htmlFor="width">Width (CM):</label>
            <input
              type="number"
              id="width"
              value={width}
              onChange={(e) => setWidth(e.target.value)}
              placeholder="Please, enter width"
              required
            />
          </div>
          <div>
            <label htmlFor="length">Length (CM):</label>
            <input
              type="number"
              id="length"
              value={length}
              onChange={(e) => setLength(e.target.value)}
              placeholder="Please, enter height"
              required
            />
          </div>
            <p>Please, provide dimensions in HxWxL format</p>
        </>
      )}
      {productType === 'DVD' && (
        <>
          <div>
            <label htmlFor="size">Size (MB):</label>
            <input
              type="number"
              id="size"
              value={size}
              onChange={(e) => setSize(e.target.value)}
              placeholder="Please, enter size"
              required
            />
          </div>
            <p>Please, provide size in Megabytes</p>
        </>
      )}
      {productType === 'Book' && (
        <>
          <div>
            <label htmlFor="weight">Weight (KG):</label>
            <input
              type="number"
              id="weight"
              value={weight}
              onChange={(e) => setWeight(e.target.value)}
              placeholder="Please, enter weight"
              required
            />
          </div>
            <p>Please, provide weight in KG</p>
        </>
      )}
        <div>
        <button type="submit">Save</button>
        <button type="button" onClick={handleCancel}>Cancel</button>
      </div>
    </form>
  </div>
);

}

export default AddProduct;
