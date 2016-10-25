/**
 * AuthRequiredContainer
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {connect} from 'react-redux';
import {browserHistory} from 'react-router';

/**
 * class AuthRequiredContainer
 *
 * Checks if user is logged in and redirect to login page if not.
 */
class AuthRequiredContainer extends React.Component {
  componentWillMount() {
    this.checkAuth();
  }

  checkAuth() {
    if (!this.props.isAuthenticated) {
      let redirectAfterLogin = this.props.location.pathname;
      browserHistory.push('/login?next=' + redirectAfterLogin);
    }
  }

  render() {
    return this.props.children;
  }
}

const mapStateToProps = (state) => {
  return {
    isAuthenticated: state.auth.isAuthenticated
  }
};

export default connect(mapStateToProps)(AuthRequiredContainer);