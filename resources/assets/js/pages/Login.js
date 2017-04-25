import React, { Component } from 'react';
import Form from '../components/Form';
import auth from '../auth';

class Login extends Component {
  constructor(props) {
    super(props);
    this.handleSubmitSuccess = this.handleSubmitSuccess.bind(this);
  }

  handleSubmitSuccess(user) {
    auth.authenticate(user);
    /* eslint-disable react/prop-types */
    this.props.history.push('/');
  }

  render() {
    return (
      <div className="Login">
        <Form
          uri="http://story.dev/login"
          onSubmitSuccess={this.handleSubmitSuccess}
          fields={[
            {
              name: 'email',
              type: 'Email',
              label: 'E-mail Address',
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
            {
              name: 'submit',
              type: 'Button',
              label: 'Login',
              isSubmit: true,
            },
          ]}
        />
      </div>
    );
  }
}

export default Login;
