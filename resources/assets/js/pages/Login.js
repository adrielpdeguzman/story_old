import React, { Component } from 'react';
import Form from '../components/Form';

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {};
  }

  render() {
    return (
      <div className="Login">
        <Form
          fields={[
            {
              name: 'username',
              type: 'Text',
              label: 'Username',
              required: true,
            },
            {
              name: 'password',
              type: 'Password',
              label: 'Password',
              required: true,
            },
            {
              name: 'remember',
              type: 'Checkbox',
              label: 'Remember Me',
            },
          ]}
        />
      </div>
    );
  }
}

export default Login;
