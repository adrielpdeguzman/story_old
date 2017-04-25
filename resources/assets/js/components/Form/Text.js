import React from 'react';
import PropType from 'prop-types';

const propTypes = {
  name: PropType.string.isRequired,
  label: PropType.string.isRequired,
  onChange: PropType.func.isRequired,
  placeholder: PropType.string,
  required: PropType.bool,
  hasError: PropType.bool,
};

const defaultProps = {
  placeholder: '',
  required: false,
  hasError: false,
};

const Text = ({ name, label, placeholder, required, onChange, hasError }) => (
  <div>
    <label htmlFor={name} className="label">{label}</label>
    <p className="control">
      <input
        type="text"
        className={`input ${hasError ? 'is-danger' : ''}`}
        id={name}
        name={name}
        required={required}
        placeholder={placeholder}
        onChange={onChange}
      />
    </p>
  </div>
);

Text.propTypes = propTypes;
Text.defaultProps = defaultProps;

export default Text;
