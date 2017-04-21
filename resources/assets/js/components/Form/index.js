import React, { Component } from 'react';
import PropType from 'prop-types';
import Text from './Text';
import Password from './Password';
import Checkbox from './Checkbox';

const components = {
  Text, Password, Checkbox,
};

const propTypes = {
  /**
   * The fields to be rendered by the form.
   */
  fields: PropType.arrayOf(PropType.shape({
    name: PropType.string,
    type: PropType.oneOf(Object.keys(components)),
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

  /**
   * Render the field component based on field props.
   * @param object fieldProps
   */
  renderField(fieldProps) {
    const { type, ...props } = fieldProps;
    const FieldComponent = components[type];
    return (
      <FieldComponent
        key={fieldProps.name}
        onChange={this.handleInputChange}
        {...props}
      />
    );
  }

  render() {
    const formFields = this.props.fields.map(field => this.renderField(field));

    return (
      <form>
        {formFields}
      </form>
    );
  }
}

Form.propTypes = propTypes;

export default Form;
