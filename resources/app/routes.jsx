import React from 'react';
import {Route, IndexRoute} from 'react-router';

import App from './views/App';
import Home from './views/Home';
import About from './views/About';
import Stuff from './views/Stuff';
import Contact from './views/Contact';
import Login from './views/Login';
import Signup from './views/Signup';
import NotFoundPage from './views/NotFoundPage';
import My from './views/my/My';
import AddTodo from './views/my/AddTodo';

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
