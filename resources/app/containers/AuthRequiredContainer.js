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
import * as authActions from './../actions/authActions';
import * as userActions from './../actions/userActions';

/**
 * class AuthRequiredContainer
 *
 * Checks if user is logged in and redirect to login page if not.
 */
class AuthRequiredContainer extends React.Component {

  render() {
    if (!this.props.auth.isAuthenticated) {
      let redirectAfterLogin = this.props.location.pathname;
      browserHistory.push('/login?next=' + redirectAfterLogin);
      return null;
    }

    // Check if access token has already expired
    if (this.props.auth.tokenExpiresAt <= Date.now()) {
      // Generate refresh token
      this.props.refreshToken();
    }

    // Check if user data exists
    if (this.props.user.id == undefined) {
      // Fetch user data
      this.props.getUserData();
    }

    return this.props.children;
  }
}

const mapStateToProps = (state) => {
  return {
    auth: state.auth,
    user: state.user
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    refreshToken: () => {
      dispatch(authActions.refreshToken());
    },
    getUserData: () => {
      dispatch(userActions.getUserData());
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(AuthRequiredContainer);