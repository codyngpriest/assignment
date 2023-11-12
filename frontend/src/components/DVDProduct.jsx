import React, { Component } from 'react';

class DVDProduct extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    const { sku, name, price, size } = this.props;

    return (
      <div>
        <h3>{sku}</h3>
        <p>{name}</p>
        <p>{price} $</p>
        <p>Size: {size} MB</p>
      </div>
    );
  }
}

export default DVDProduct;

