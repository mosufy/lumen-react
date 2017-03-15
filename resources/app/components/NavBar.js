import React from 'react';
import {browserHistory} from 'react-router';
import NavLink from './common/NavLink';

export default class NavBar extends React.Component {
  static defaultProps = {
    navIndex: true
  };

  static propTypes = {
    navIndex: React.PropTypes.bool
  };

  render() {
    let navlinks;

    if (this.props.pageTemplate == 'public') {
      navlinks = (
        <ul className="nav nav-pills pull-right">
          <NavLink to="/" {...this.props.navIndex}>Home</NavLink>
          <NavLink to="about">About</NavLink>
          <NavLink to="contact">Contact</NavLink>
          <NavLink to="login">Login</NavLink>
        </ul>
      );
    } else {
      navlinks = (
        <ul className="nav nav-pills pull-right">
          <NavLink to="dashboard" {...this.props.navIndex}>My TODOs</NavLink>
          <li onClick={this.props.logoutLink}><a href="/">Log Out</a></li>
        </ul>
      );
    }

    return (
      <nav>
        {navlinks}
      </nav>
    );
  }
}
