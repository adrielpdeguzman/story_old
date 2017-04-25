import React from 'react';
import ReactDOM from 'react-dom';
import App from './pages/App';
import auth from './auth';

/**
 * Initial check if user is authenticated.
 */
auth.fetchUser()
  .then(() => {
    ReactDOM.render(
      <App />,
      document.getElementById('app'),
    );
  });
