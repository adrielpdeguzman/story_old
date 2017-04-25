import React, { Component } from 'react';
import PropType from 'prop-types';
import axios from 'axios';
import Text from './Text';
import Password from './Password';
import Checkbox from './Checkbox';
import Button from './Button';
import Email from './Email';

const components = {
  Text, Password, Checkbox, Button, Email,
};

const propTypes = {
  /**
   * The URI endpoint to send the request to.
   */
  uri: PropType.string.isRequired,
  /**
   * The type of request to be sent on form submit.
   */
  method: PropType.oneOf(['post', 'put', 'patch']),
  /**
   * The fields to be rendered by the form.
   */
  fields: PropType.arrayOf(PropType.shape({
    name: PropType.string,
    type: PropType.oneOf(Object.keys(components)),
    label: PropType.string,
    required: PropType.bool,
    isSubmit: PropType.bool,
  })).isRequired,
  /**
   * The callback function to be called when submit request is successful.
   */
  onSubmitSuccess: PropType.func.isRequired,
};

const defaultProps = {
  method: 'post',
};

class Form extends Component {
  constructor(props) {
    super(props);

    /**
     * Initialize fields state to make controlled inputs.
     */
    const fields = {};
    const inputFields = props.fields.filter(field => field.type !== 'Button');
    inputFields.forEach((field) => {
      if (field.type === 'Checkbox') {
        const isChecked = !!field.checked;
        fields[field.name] = isChecked;
      } else {
        fields[field.name] = '';
      }
    });

    this.state = {
      fields,
      errors: {},
      isLoading: false,
    };

    this.handleInputChange = this.handleInputChange.bind(this);
    this.handleFormSubmit = this.handleFormSubmit.bind(this);
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
   * Handle the form submission.
   */
  handleFormSubmit(e) {
    const { uri, method, onSubmitSuccess } = this.props;
    const { fields } = this.state;
    e.preventDefault();
    this.setState({ isLoading: true });
    axios[method](uri, fields)
      .then(({ data }) => {
        this.setState({
          errors: {},
          isLoading: false,
        });
        onSubmitSuccess(data);
      })
      .catch((error) => {
        this.setState({
          errors: error.response.data,
          isLoading: false,
        });
      });
  }

  /**
   * Render the field component based on field props.
   */
  renderField(fieldProps) {
    const { type, ...props } = fieldProps;
    const { errors } = this.state;
    const FieldComponent = components[type];
    const hasError = Object.prototype.hasOwnProperty.call(errors, fieldProps.name);

    return (
      <div
        className="field"
        key={fieldProps.name}
      >
        <FieldComponent
          onChange={this.handleInputChange}
          hasError={hasError}
          {...props}
        />
        {hasError ?
          (<p className="help is-danger">{errors[fieldProps.name]}</p>) : ''
        }
      </div>
    );
  }

  render() {
    const { fields } = this.props;
    const formFields = fields.map(field => this.renderField(field));

    return (
      <form onSubmit={this.handleFormSubmit}>
        {formFields}
      </form>
    );
  }
}

Form.propTypes = propTypes;
Form.defaultProps = defaultProps;

export default Form;
