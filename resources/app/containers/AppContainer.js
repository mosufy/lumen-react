/**
 * AppContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import {connect} from 'react-redux';
import {browserHistory} from 'react-router';
import App from './../components/App';
import * as authActions from './../actions/authActions';
import * as todoActions from './../actions/todoActions';
import * as userActions from './../actions/userActions';

class AppContainer extends React.Component {
  render() {
    let path = this.props.location.pathname;
    let pageTemplate = 'public';

    if (path && path.substring(0, 9) == 'dashboard') {
      pageTemplate = 'dashboard';
    }

    return (
      <App pageTemplate={pageTemplate} user={this.props.user} {...this.props}/>
    )
  }
}

const mapStateToProps = (state) => {
  return {
    user: state.user
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    logoutLink: (e) => {
      e.preventDefault();
      dispatch(todoActions.resetTodo());
      dispatch(userActions.removeUserData());
      dispatch(authActions.resetAccessToken());
      browserHistory.push('/');
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(AppContainer);