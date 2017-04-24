import React from 'react';
import PropType from 'prop-types';

const propTypes = {
  name: PropType.string.isRequired,
  label: PropType.string.isRequired,
  isSubmit: PropType.bool,
};

const defaultProps = {
  isSubmit: false,
};

const Button = ({ name, label, isSubmit }) => (
  <div className="field">
    <p className="control">
      <button
        type={isSubmit ? 'submit' : false}
        id={name}
        name={name}
        className={`button ${isSubmit ? 'is-primary' : ''}`}
      >
        {label}
      </button>
    </p>
  </div>
);

Button.propTypes = propTypes;
Button.defaultProps = defaultProps;

export default Button;
