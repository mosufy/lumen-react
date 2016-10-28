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
import {refreshToken, getUserData} from './../helpers/sdk';

/**
 * class AuthRequiredContainer
 *
 * Checks if user is logged in and redirect to login page if not.
 */
class AuthRequiredContainer extends React.Component {
  componentWillMount() {
    // Check if user is authenticated
    if (!this.props.isAuthenticated) {
      let redirectAfterLogin = this.props.location.pathname;
      browserHistory.push('/login?next=' + redirectAfterLogin);
    } else {
      // Check if access token has already expired
      if (this.props.tokenExpiresAt <= Date.now()) {
        // Generate refresh token
        this.props.refreshToken(this.props.clientAccessToken, this.props.refreshTokenStr);
      }
    }

    // Check if user data exists
    if (this.props.user.id == undefined) {
      // Fetch user data
      this.props.getUserData(this.props.accessToken);
    }
  }

  render() {
    return this.props.children;
  }
}

const mapStateToProps = (state) => {
  return {
    isAuthenticated: state.auth.isAuthenticated,
    tokenExpiresAt: state.auth.tokenExpiresAt,
    clientAccessToken: state.auth.clientAccessToken,
    accessToken: state.auth.accessToken,
    refreshTokenStr: state.auth.refreshToken,
    user: state.user
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    refreshToken: (clientAccessToken, refreshTokenStr) => {
      refreshToken(clientAccessToken, refreshTokenStr).then(function (response) {
        dispatch(authActions.saveAccessToken(response));
      }).catch(function (error) {
        console.log('Failed refreshing access token. Please try again');
        console.log(error);
      });
    },
    getUserData: (accessToken) => {
      getUserData(accessToken).then(function (response) {
        dispatch(userActions.saveUserData(response));
      }).catch(function (error) {
        console.log('Failed getting user data');
        console.log(error);
      });
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(AuthRequiredContainer);