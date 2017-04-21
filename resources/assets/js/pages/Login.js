import React, { Component } from 'react';

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      loginForm: {
        username: '',
        password: '',
        remember: false,
      },
    };

    this.handleInputChange = this.handleInputChange.bind(this);
  }

  /**
   * Handle input change on login form.
   * @param Event e
   */
  handleInputChange({ target }) {
    const loginForm = Object.assign({}, this.state.loginForm, {
      [target.id]: target.type === 'checkbox' ? target.checked : target.value,
    });
    this.setState({ loginForm });
  }

  render() {
    const { username, password, remember } = this.state.loginForm;
    return (
      <div className="Login">
        <form>
          <div className="field">
            <label htmlFor="username" className="label">Username</label>
            <p className="control">
              <input
                className="input"
                id="username"
                placeholder="Username"
                type="text"
                value={username}
                onChange={this.handleInputChange}
              />
            </p>
          </div>
          <div className="field">
            <label htmlFor="password" className="label">Password</label>
            <p className="control">
              <input
                className="input"
                id="password"
                placeholder="Password"
                type="password"
                value={password}
                onChange={this.handleInputChange}
              />
            </p>
          </div>
          <div className="field">
            <label htmlFor="remember" className="checkbox">
              <p className="control">
                <input
                  type="checkbox"
                  id="remember"
                  checked={remember}
                  onChange={this.handleInputChange}
                /> Remember Me
              </p>
            </label>
          </div>
        </form>
      </div>
    );
  }
}

export default Login;
