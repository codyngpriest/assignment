import React, { Component } from 'react';

class FurnitureProduct extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    const { sku, name, price, width, length, height } = this.props;

    return (
      <div>
        <h3>{sku}</h3>
        <p>{name}</p>
        <p>{price} $</p>
        <p>Dimensions: {length} x {width} x {height}</p>
      </div>
    );
  }
}

export default FurnitureProduct;

