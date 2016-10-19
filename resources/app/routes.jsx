import React from 'react';
import {Route, IndexRoute} from 'react-router';

import App from './components/pages/app/App';
import Home from './components/pages/app/Home';
import About from './components/pages/app/About';
import Stuff from './components/pages/app/Stuff';
import Contact from './components/pages/app/Contact';
import Login from './components/pages/app/Login';
import Signup from './components/pages/app/Signup';
import NotFoundPage from './components/pages/app/NotFoundPage';
import My from './components/pages/dashboard/Dashboard';
import AddTodo from './components/pages/dashboard/AddTodo';

export default (
  <Route path="/" component={App}>
    <IndexRoute component={Home}/>
    <Route path="about" component={About}>
      <Route path="stuff" component={Stuff}/>
    </Route>
    <Route path="contact" component={Contact}/>
    <Route path="login" component={Login}/>
    <Route path="signup" component={Signup}/>
    <Route path="my" component={My}/>
    <Route path="my/add" component={AddTodo}/>
    <Route path="*" component={NotFoundPage} />
  </Route>
);
