import React from 'react';
import {
  BrowserRouter as Router,
  Route,
  Link,
} from 'react-router-dom';
import Login from './Login';

const App = () => (
  <Router>
    <div>
      <Link to="/login">Login</Link>

      <Route exact path="/login" component={Login} />
    </div>
  </Router>
);

export default App;
