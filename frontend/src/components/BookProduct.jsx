import React, { Component } from 'react';

class BookProduct extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    const { sku, name, price, weight } = this.props;

    return (
      <div>
        <h3>{sku}</h3>
        <p>{name}</p>
        <p>{price} $</p>
        <p>Weight: {weight} Kg</p>
      </div>
    );
  }
}

export default BookProduct;

