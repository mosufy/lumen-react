/**
 * LoginContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {browserHistory} from 'react-router';
import Login from './../components/Login';

export default class LoginContainer extends React.Component {
  submitForm(e) {
    e.preventDefault();
    browserHistory.push('/dashboard');
  }

  render() {
    return (
      <Login submitForm={this.submitForm}/>
    );
  }
}