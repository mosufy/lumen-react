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
import * as actionCreators from './../actions';

class AppContainer extends React.Component {
  render() {
    var path = this.props.location.pathname;
    var pageTemplate = 'public';

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
      dispatch(actionCreators.resetTodo());
      dispatch(actionCreators.removeUserData());
      dispatch(actionCreators.logout());
      browserHistory.push('/');
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(AppContainer);