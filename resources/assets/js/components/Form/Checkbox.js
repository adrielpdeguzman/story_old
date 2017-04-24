import React from 'react';
import PropType from 'prop-types';

const propTypes = {
  name: PropType.string.isRequired,
  label: PropType.string.isRequired,
  onChange: PropType.func.isRequired,
  checked: PropType.bool,
};

const defaultProps = {
  checked: false,
};

const Checkbox = ({ name, label, checked, onChange }) => (
  <p className="control">
    <label htmlFor={name} className="checkbox">
      <input
        type="checkbox"
        id={name}
        name={name}
        onChange={onChange}
        defaultChecked={checked}
      />
      {label}
    </label>
  </p>
);

Checkbox.propTypes = propTypes;
Checkbox.defaultProps = defaultProps;

export default Checkbox;
