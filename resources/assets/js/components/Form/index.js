import React, { Component } from 'react';
import PropType from 'prop-types';
import Text from './Text';

const propTypes = {
  /**
   * The fields to be rendered by the form.
   */
  fields: PropType.arrayOf(PropType.shape({
    name: PropType.string,
    type: PropType.oneOf([
      'Text', 'Password',
    ]),
    label: PropType.string,
    required: PropType.bool,
  })).isRequired,
};

class Form extends Component {
  constructor(props) {
    super(props);
    const fields = {};
    props.fields.forEach((field) => {
      fields[field.name] = field.type === 'checkbox' ? field.checked : '';
    });

    this.state = {
      fields,
      errors: {},
      isLoading: false,
    };

    this.handleInputChange = this.handleInputChange.bind(this);
  }

  /**
   * Handle input change on form fields.
   */
  handleInputChange({ target }) {
    const fields = Object.assign({}, this.state.fields, {
      [target.id]: target.type === 'checkbox' ? target.checked : target.value,
    });
    this.setState({ fields });
  }

  render() {
    return (
      <form />
    );
  }
}

Form.propTypes = propTypes;

export default Form;
