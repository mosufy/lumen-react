import React from 'react';
import {Route, IndexRoute} from 'react-router';

import AppContainer from './containers/AppContainer';
import HomeContainer from './containers/HomeContainer';
import AboutContainer from './containers/AboutContainer';
import StuffContainer from './containers/StuffContainer';
import ContactContainer from './containers/ContactContainer';
import LoginContainer from './containers/LoginContainer';
import SignupContainer from './containers/SignupContainer';
import NotFoundPageContainer from './containers/NotFoundPageContainer';
import DashboardContainer from './containers/DashboardContainer';

export default (
  <Route path="/" component={AppContainer}>
    <IndexRoute component={HomeContainer}/>
    <Route path="about" component={AboutContainer}>
      <Route path="stuff" component={StuffContainer}/>
    </Route>
    <Route path="contact" component={ContactContainer}/>
    <Route path="login" component={LoginContainer}/>
    <Route path="signup" component={SignupContainer}/>
    <Route path="dashboard" component={DashboardContainer}/>
    <Route path="*" component={NotFoundPageContainer} />
  </Route>
);
