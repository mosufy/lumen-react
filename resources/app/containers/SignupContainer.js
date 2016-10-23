/**
 * SignupContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {browserHistory} from 'react-router';
import Signup from './../components/Signup';

export default class SignupContainer extends React.Component {
  submitForm(e) {
    e.preventDefault();
    browserHistory.push('/dashboard');
  }

  render() {
    return (
      <Signup submitForm={this.submitForm}/>
    );
  }
}