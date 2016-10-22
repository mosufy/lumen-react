import React from 'react';
import {Route, IndexRoute} from 'react-router';

import App from './components/app/App';
import Home from './components/app/Home';
import About from './components/app/About';
import Stuff from './components/app/Stuff';
import Contact from './components/app/Contact';
import Login from './components/app/Login';
import Signup from './components/app/Signup';
import NotFoundPage from './components/app/NotFoundPage';
import Dashboard from './components/dashboard/Dashboard';

export default (
  <Route path="/" component={App}>
    <IndexRoute component={Home}/>
    <Route path="about" component={About}>
      <Route path="stuff" component={Stuff}/>
    </Route>
    <Route path="contact" component={Contact}/>
    <Route path="login" component={Login}/>
    <Route path="signup" component={Signup}/>
    <Route path="dashboard" component={Dashboard}/>
    <Route path="*" component={NotFoundPage} />
  </Route>
);
