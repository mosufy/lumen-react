import React from 'react';
import {Route, IndexRoute} from 'react-router';

import App from './views/App.jsx';
import Home from './views/Home.jsx';
import About from './views/About.jsx';
import Stuff from './views/Stuff.jsx';
import Contact from './views/Contact.jsx';
import Login from './views/Login.jsx';
import Signup from './views/Signup.jsx';
import My from './views/my/My.jsx';
import AddTodo from './views/my/AddTodo.jsx';

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
  </Route>
);
