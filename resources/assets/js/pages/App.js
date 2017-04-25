import React from 'react';
import {
  BrowserRouter as Router,
  Route,
  Link,
} from 'react-router-dom';
import Home from './Home';
import Login from './Login';

const App = () => (
  <Router>
    <div className="App">
      <Link to="/login">Login</Link>

      <Route exact path="/" component={Home} />
      <Route exact path="/login" component={Login} />
    </div>
  </Router>
);

export default App;
